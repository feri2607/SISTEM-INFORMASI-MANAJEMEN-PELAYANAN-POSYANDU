<?php
// app/Http/Controllers/Warga/WargaController.php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Warga;
use App\Http\Requests\WargaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WargaController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display the warga data form or detail
     */
    public function index()
    {
        $user = Auth::user();
        $warga = $user->warga;

        // Jika belum punya data, redirect ke create
        if (!$warga) {
            return redirect()->route('warga.warga.create')
                ->with('info', 'Silakan lengkapi data warga Anda.');
        }

        return view('warga.index', compact('warga'));
    }

    /**
     * Show the form for creating warga data
     */
    public function create()
    {
        $this->authorize('create', Warga::class);

        $user = Auth::user();
        
        // Cek apakah sudah punya data
        if ($user->warga) {
            return redirect()->route('warga.warga.index')
                ->with('warning', 'Anda sudah memiliki data warga.');
        }

        return view('warga.create');
    }

    /**
     * Store a newly created warga data
     */
    public function store(WargaRequest $request)
    {
        $this->authorize('create', Warga::class);

        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['verification_status'] = 'pending';

        // Upload KTP
        if ($request->hasFile('ktp_path')) {
            $file = $request->file('ktp_path');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('warga/ktp', $filename, 'public');
            $data['ktp_path'] = $path;
        }

        // Upload KK
        if ($request->hasFile('kk_path')) {
            $file = $request->file('kk_path');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('warga/kk', $filename, 'public');
            $data['kk_path'] = $path;
        }

        Warga::create($data);

        return redirect()->route('warga.warga.index')
            ->with('success', 'Data warga berhasil disimpan dan sedang menunggu verifikasi kader.');
    }

    /**
     * Show the form for editing warga data
     */
    public function edit()
    {
        $user = Auth::user();
        $warga = $user->warga;

        if (!$warga) {
            return redirect()->route('warga.warga.create')
                ->with('info', 'Silakan lengkapi data warga Anda.');
        }

        $this->authorize('update', $warga);

        return view('warga.edit', compact('warga'));
    }

    /**
     * Update the specified warga data
     */
    public function update(WargaRequest $request)
    {
        $user = Auth::user();
        $warga = $user->warga;

        if (!$warga) {
            return redirect()->route('warga.warga.create')
                ->with('error', 'Data warga tidak ditemukan.');
        }

        $this->authorize('update', $warga);

        $data = $request->validated();

        // Jika sudah diverifikasi, tidak bisa mengubah data
        if ($warga->isVerified()) {
            return back()->with('error', 'Data sudah terverifikasi. Tidak dapat diubah.');
        }

        // Upload KTP
        if ($request->hasFile('ktp_path')) {
            // Hapus file lama
            if ($warga->ktp_path && Storage::disk('public')->exists($warga->ktp_path)) {
                Storage::disk('public')->delete($warga->ktp_path);
            }
            
            $file = $request->file('ktp_path');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('warga/ktp', $filename, 'public');
            $data['ktp_path'] = $path;
        }

        // Upload KK
        if ($request->hasFile('kk_path')) {
            if ($warga->kk_path && Storage::disk('public')->exists($warga->kk_path)) {
                Storage::disk('public')->delete($warga->kk_path);
            }
            
            $file = $request->file('kk_path');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('warga/kk', $filename, 'public');
            $data['kk_path'] = $path;
        }

        // Jika data diubah, set status ke pending
        if ($warga->verification_status === 'verified') {
            $data['verification_status'] = 'pending';
        }

        $warga->update($data);

        return redirect()->route('warga.warga.index')
            ->with('success', 'Data warga berhasil diperbarui dan sedang menunggu verifikasi.');
    }

    /**
     * Download KTP file
     */
    public function downloadKtp()
    {
        $user = Auth::user();
        $warga = $user->warga;

        if (!$warga || !$warga->ktp_path) {
            abort(404);
        }

        $this->authorize('view', $warga);

        return Storage::disk('public')->download($warga->ktp_path);
    }

    /**
     * Download KK file
     */
    public function downloadKk()
    {
        $user = Auth::user();
        $warga = $user->warga;

        if (!$warga || !$warga->kk_path) {
            abort(404);
        }

        $this->authorize('view', $warga);

        return Storage::disk('public')->download($warga->kk_path);
    }
}