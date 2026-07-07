<?php
// app/Http/Controllers/Warga/PelayananController.php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\HasilPelayanan;
use App\Models\Balita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PelayananController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $user = Auth::user();
        $warga = $user->warga;

        if (!$warga) {
            return redirect()->route('profile.edit')
                ->with('warning', 'Silakan lengkapi data profil Anda terlebih dahulu.');
        }

        $pelayanan = HasilPelayanan::with(['balita', 'kegiatan'])
            ->whereHas('balita', function ($query) use ($warga) {
                $query->where('warga_id', $warga->id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('warga.pelayanan.index', compact('pelayanan'));
    }

    public function show(HasilPelayanan $pelayanan)
    {
        $this->authorize('view', $pelayanan);

        $pelayanan->load(['balita', 'kegiatan', 'user']);

        return view('warga.pelayanan.show', compact('pelayanan'));
    }
}