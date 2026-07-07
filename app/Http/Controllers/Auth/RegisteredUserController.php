<?php
// app/Http/Controllers/Auth/RegisteredUserController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        // Tentukan role berdasarkan pilihan atau default
        $role = $request->role ?? 'pegawai'; // Default tetap pegawai
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect berdasarkan role
        return $this->redirectBasedOnRole($user);
    }

    /**
     * Redirect user based on their role
     */
    protected function redirectBasedOnRole($user): RedirectResponse
    {
        // Jika role warga, arahkan ke halaman lengkapi data (bukan dashboard, karena data belum ada)
        if ($user->role === 'user') {
            return redirect()->route('warga.warga.create')
                ->with('swal_success', 'Registrasi berhasil! Silakan lengkapi data diri Anda.');
        }

        // Jika role admin, ke dashboard admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('swal_success', 'Registrasi berhasil! Selamat datang di dashboard admin.');
        }

        // Default: pegawai/pegawai ke verifikasi email
        return redirect(route('verification.notice'))
            ->with('swal_success', 'Registrasi berhasil! Silakan verifikasi email Anda.');
    }
}