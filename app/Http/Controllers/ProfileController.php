<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show()
    {
        $user = Auth::user();

        // Get active sessions (simplified)
        $sessions = $this->getActiveSessions();

        return view('profile.show', compact('user', 'sessions'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'no_telepon' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old foto
            if ($user->foto && Storage::disk('public')->exists('foto-user/' . $user->foto)) {
                Storage::disk('public')->delete('foto-user/' . $user->foto);
            }

            $file = $request->file('foto');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('foto-user', $filename, 'public');
            $validated['foto'] = $filename;
        }

        $user->update($validated);

        return redirect()->route('profile.show')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.show')
            ->with('success', 'Password berhasil diubah.');
    }

    /**
     * Logout from all devices.
     */
    public function logoutAllDevices(Request $request)
    {
        $user = Auth::user();

        // Force logout from all sessions by changing password
        $user->update([
            'password' => Hash::make(Str::random(40)),
        ]);

        // Logout current session
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah logout dari semua perangkat.');
    }

    /**
     * Delete the user's account.
     */
    public function updateAvatar(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'foto' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            // Delete old foto
            if ($user->foto && Storage::disk('public')->exists('foto-user/' . $user->foto)) {
                Storage::disk('public')->delete('foto-user/' . $user->foto);
            }

            $file = $request->file('foto');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('foto-user', $filename, 'public');
            
            $user->update([
                'foto' => $filename
            ]);
        }

        return redirect()->route('profile.show')
            ->with('success', 'Foto profil berhasil diperbarui.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'password' => ['required', 'current_password'],
        ]);

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

        return redirect()->route('login')
            ->with('success', 'Akun Anda telah dihapus.');
    }

    /**
     * Get active sessions (simplified implementation).
     */
    private function getActiveSessions()
    {
        // In a real implementation, you would track sessions in a database
        // This is a simplified version
        $sessions = [];

        // Current session
        $sessions[] = [
            'device' => request()->userAgent(),
            'ip' => request()->ip(),
            'last_activity' => now()->format('d M Y H:i'),
            'current' => true,
        ];

        return $sessions;
    }

    /**
     * Update last login info
     */
    public function updateLastLogin(Request $request)
    {
        $user = Auth::user();
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
            'last_login_browser' => $request->userAgent(),
        ]);
    }
}