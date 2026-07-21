<?php
// app/Http/Controllers/Admin/UserController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Admin\UpdateUserRoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $query = User::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role') && $request->role !== 'all') {
            if ($request->role === 'warga') {
                // Include legacy 'user' role as well
                $query->whereIn('role', ['warga', 'user']);
            } else {
                $query->where('role', $request->role);
            }
        }

        // Filter by provider
        if ($request->filled('provider') && $request->provider !== 'all') {
            if ($request->provider === 'email') {
                $query->whereNull('provider');
            } else {
                $query->where('provider', $request->provider);
            }
        }

        // Filter by verification status
        if ($request->filled('verification') && $request->verification !== 'all') {
            if ($request->verification === 'verified') {
                $query->whereNotNull('email_verified_at');
            } else {
                $query->whereNull('email_verified_at');
            }
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $users = $query->paginate(10);

        $stats = [
            'total_admin' => User::where('role', 'admin')->count(),
            'total_user'  => User::whereIn('role', ['warga', 'user'])->count(),
            'verified'    => User::whereNotNull('email_verified_at')->count(),
            'unverified'  => User::whereNull('email_verified_at')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function editRole(User $user)
    {
        $this->authorize('updateRole', $user);

        return view('admin.users.edit-role', compact('user'));
    }

    public function updateRole(UpdateUserRoleRequest $request, User $user)
    {
        $this->authorize('updateRole', $user);

        // Check if trying to demote the last admin
        if ($user->role === 'admin' && !in_array($request->role, ['admin'])) {
            $adminCount = User::where('role', 'admin')->count();
            if ($adminCount <= 1) {
                throw ValidationException::withMessages([
                    'role' => 'Tidak dapat menurunkan role admin terakhir.',
                ]);
            }
        }

        $oldRole = $user->role;
        $user->role = $request->role;
        $user->save();

        // Log activity
        $this->logActivity($user, $oldRole, $request->role);

        return redirect()->route('admin.users.index')
            ->with('success', 'Role pengguna berhasil diubah.');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        // Prevent deleting self
        if ($user->id === Auth::id()) {
            return redirect()->back()
                ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        DB::beginTransaction();
        try {
            // Delete related data
            $user->warga()->delete();
            $user->delete();

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'Pengguna berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete user: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Gagal menghapus pengguna.');
        }
    }

    private function logActivity($user, $oldRole, $newRole)
    {
        Log::info('User role updated', [
            'admin' => Auth::user()->email,
            'user' => $user->email,
            'old_role' => $oldRole,
            'new_role' => $newRole,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now(),
        ]);
    }
}