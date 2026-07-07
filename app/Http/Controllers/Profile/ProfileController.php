<?php
// app/Http/Controllers/Profile/ProfileController.php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LoginActivity;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Http\Requests\Profile\UpdateAvatarRequest;
use App\Http\Requests\Profile\UpdatePreferencesRequest;
use App\Http\Requests\Profile\DeleteAccountRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProfileController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display the profile page
     */
 public function index()
{
    $user = Auth::user();
    $loginActivities = LoginActivity::where('user_id', $user->id)
        ->orderBy('login_at', 'desc')
        ->limit(10)
        ->get();
    $preferences = $user->getPreferences();

    return view('profile.profilewarga.index', compact('user', 'loginActivities', 'preferences'));
}

    /**
     * Update profile information
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        
        $data = $request->validated();
        
        // Check if email changed, reset verification if changed
        if ($data['email'] !== $user->email) {
            $data['email_verified_at'] = null;
        }

        $user->update($data);

        return redirect()->route('profile.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update avatar
     */
    public function updateAvatar(UpdateAvatarRequest $request)
    {
        $user = Auth::user();

        // Delete old foto
        if ($user->foto && Storage::disk('public')->exists('foto-user/' . $user->foto)) {
            Storage::disk('public')->delete('foto-user/' . $user->foto);
        }

        // Upload new foto
        $file = $request->file('avatar');
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('foto-user', $filename, 'public');

        $user->foto = $filename;
        $user->save();

        return redirect()->route('profile.index')
            ->with('success', 'Foto profil berhasil diperbarui.');
    }

    /**
     * Delete avatar
     */
    public function deleteAvatar()
    {
        $user = Auth::user();

        if ($user->foto && Storage::disk('public')->exists('foto-user/' . $user->foto)) {
            Storage::disk('public')->delete('foto-user/' . $user->foto);
        }

        $user->foto = null;
        $user->save();

        return redirect()->route('profile.index')
            ->with('success', 'Foto profil berhasil dihapus.');
    }

    /**
     * Update password
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = Auth::user();

        // Check if user is using social login
        if ($user->isSocialLogin() && empty($user->password)) {
            return back()->with('error', 'Akun ini menggunakan Social Login. Tidak dapat mengubah password.');
        }

        $user->password = Hash::make($request->password);
        $user->password_changed_at = now();
        $user->save();

        return redirect()->route('profile.index')
            ->with('success', 'Password berhasil diperbarui.');
    }

    /**
     * Create password for social login user
     */
    public function createPassword(Request $request)
    {
        $user = Auth::user();

        if (!$user->isSocialLogin() || !empty($user->password)) {
            return back()->with('error', 'Akun ini sudah memiliki password.');
        }

        $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user->password = Hash::make($request->password);
        $user->password_changed_at = now();
        $user->save();

        return redirect()->route('profile.index')
            ->with('success', 'Password berhasil dibuat.');
    }

    /**
     * Update preferences
     */
    public function updatePreferences(UpdatePreferencesRequest $request)
    {
        $user = Auth::user();
        
        $user->updatePreferences($request->validated());

        return redirect()->route('profile.index')
            ->with('success', 'Preferensi berhasil diperbarui.');
    }

    /**
     * Delete account (soft delete)
     */
    public function deleteAccount(DeleteAccountRequest $request)
    {
        $user = Auth::user();

        // Delete foto
        if ($user->foto && Storage::disk('public')->exists('foto-user/' . $user->foto)) {
            Storage::disk('public')->delete('foto-user/' . $user->foto);
        }

        // Soft delete user
        $user->delete();

        // Logout
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Akun Anda telah dihapus.');
    }

    /**
     * Get login activities
     */
    public function getLoginActivities()
    {
        $activities = LoginActivity::where('user_id', Auth::id())
            ->orderBy('login_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json($activities);
    }
}