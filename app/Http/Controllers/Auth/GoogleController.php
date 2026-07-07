<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    // Redirect ke Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback dari Google
    public function handleGoogleCallback()
    {
        try {
            \Illuminate\Support\Facades\Log::info('Google callback initiated.');
            $googleUser = Socialite::driver('google')->user();
            \Illuminate\Support\Facades\Log::info('Google user fetched', ['email' => $googleUser->getEmail()]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Socialite failed', ['error' => $e->getMessage()]);
            return redirect()->route('login')->with('error', 'Login dengan Google gagal di tahap autentikasi.');
        }

        // Cari user berdasarkan provider_id atau email
        $user = User::where('provider_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if ($user) {
            \Illuminate\Support\Facades\Log::info('Existing user found', ['id' => $user->id, 'role' => $user->role]);
            // Blokir admin dan pegawai dari login Google
            if (in_array($user->role, ['admin', 'pegawai'])) {
                \Illuminate\Support\Facades\Log::warning('Blocked admin/pegawai via Google login');
                return redirect()->route('login')
                    ->with('error', 'Akun admin/pegawai tidak dapat login menggunakan Google. Gunakan email dan password.');
            }

            // Update provider info jika belum ada
            $user->update([
                'provider'          => 'google',
                'provider_id'       => $googleUser->getId(),
                'email_verified_at' => $user->email_verified_at ?? now(),
            ]);
            \Illuminate\Support\Facades\Log::info('Existing user updated successfully');
        } else {
            \Illuminate\Support\Facades\Log::info('Creating new user from Google');
            // Buat user baru dengan role default 'user' (Warga)
            $user = User::create([
                'name'              => $googleUser->getName(),
                'email'             => $googleUser->getEmail(),
                'password'          => Hash::make(uniqid()),
                'provider'          => 'google',
                'provider_id'       => $googleUser->getId(),
                'email_verified_at' => now(),
                'role'              => 'user',
            ]);
        }

        // Login user (hanya warga/user)
        Auth::login($user, true); // Use remember=true
        request()->session()->regenerate();
        \Illuminate\Support\Facades\Log::info('User authenticated, redirecting to warga.dashboard');

        return redirect()->intended(route('warga.dashboard'))
            ->with('success', 'Selamat datang, ' . $user->name . '!');
    }
}