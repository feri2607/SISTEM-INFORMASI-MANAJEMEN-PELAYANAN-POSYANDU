<?php
// app/Http/Controllers/Warga/LansiaController.php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use App\Models\PemeriksaanLansia;
use App\Models\JadwalSenamLansia;
use App\Models\Article;
use App\Services\LansiaService;
use App\Http\Requests\LansiaRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LansiaController extends Controller
{
    use AuthorizesRequests;

    public function __construct(protected LansiaService $lansiaService) {}

    public function index()
    {
        $user  = Auth::user();
        $warga = $user->warga;

        if (!$warga) {
            return redirect()->route('warga.warga.create')
                ->with('warning', 'Silakan lengkapi data warga Anda terlebih dahulu.');
        }

        $lansia = Lansia::where('warga_id', $warga->id)->first();

        $stats = [
            'tekanan_darah'      => $lansia?->tekanan_darah_terakhir ?? '-',
            'gula_darah'         => $lansia?->gula_darah_terakhir ?? '-',
            'kolesterol'         => $lansia?->kolesterol_terakhir ?? '-',
            'berat_badan'        => $lansia?->berat_badan_terakhir ?? '-',
            'tinggi_badan'       => $lansia?->tinggi_badan_terakhir ?? '-',
            'imt'                => $lansia?->imt_terakhir ?? '-',
            'pemeriksaan_terakhir'=> $lansia?->pemeriksaan_terakhir_tanggal ?? '-',
        ];

        $chartData = $lansia ? $this->lansiaService->getChartData($lansia) : null;

        $riwayatPemeriksaan = $lansia
            ? $lansia->pemeriksaan()->with('user')->paginate(10)
            : collect();

        $jadwalSenam = JadwalSenamLansia::where('tanggal', '>=', now()->toDateString())
            ->where('status', 'aktif')
            ->orderBy('tanggal')
            ->get();

        $artikel = [
            ['judul' => 'Hipertensi pada Lansia',        'icon' => '🩺', 'warna' => 'red',    'deskripsi' => 'Kenali gejala dan cara mencegah tekanan darah tinggi pada usia lanjut.'],
            ['judul' => 'Diabetes & Pola Makan',          'icon' => '🍎', 'warna' => 'orange', 'deskripsi' => 'Panduan pola makan sehat untuk penderita diabetes usia lanjut.'],
            ['judul' => 'Kolesterol Sehat',                'icon' => '💊', 'warna' => 'yellow', 'deskripsi' => 'Tips menjaga kadar kolesterol dalam batas normal.'],
            ['judul' => 'Olahraga untuk Lansia',          'icon' => '🏃', 'warna' => 'green',  'deskripsi' => 'Jenis olahraga ringan dan aman untuk lansia.'],
            ['judul' => 'Pencegahan Jatuh',                'icon' => '⚠️', 'warna' => 'blue',   'deskripsi' => 'Tips mencegah jatuh dan cidera pada lansia di rumah.'],
            ['judul' => 'Kesehatan Tulang',                'icon' => '🦴', 'warna' => 'purple', 'deskripsi' => 'Cara menjaga kepadatan tulang dan mencegah osteoporosis.'],
            ['judul' => 'Pola Makan Sehat di Usia Lanjut','icon' => '🥦', 'warna' => 'teal',   'deskripsi' => 'Rekomendasi asupan gizi seimbang bagi lansia.'],
        ];

        return view('warga.lansia.index', compact('lansia', 'stats', 'chartData', 'riwayatPemeriksaan', 'jadwalSenam', 'artikel'));
    }

    public function create()
    {
        $user  = Auth::user();
        $warga = $user->warga;

        if (!$warga) {
            return redirect()->route('warga.warga.create')
                ->with('warning', 'Silakan lengkapi data warga Anda terlebih dahulu.');
        }

        // Only one lansia per warga
        if (Lansia::where('warga_id', $warga->id)->exists()) {
            return redirect()->route('warga.lansia.index')
                ->with('info', 'Data lansia sudah ada. Silakan edit jika perlu mengubah data.');
        }

        return view('warga.lansia.create');
    }

    public function store(LansiaRequest $request)
    {
        $user  = Auth::user();
        $warga = $user->warga;

        if (!$warga) {
            return redirect()->route('warga.warga.create');
        }

        $this->lansiaService->storeLansia(
            $request->except('foto'),
            $warga->id,
            $request->hasFile('foto') ? $request->file('foto') : null
        );

        return redirect()->route('warga.lansia.index')
            ->with('success', 'Data lansia berhasil ditambahkan. Menunggu verifikasi dari pegawai.');
    }

    public function show(Lansia $lansia)
    {
        $this->authorize('view', $lansia);
        $lansia->load(['pemeriksaan.user', 'warga']);
        $chartData = $this->lansiaService->getChartData($lansia);
        return view('warga.lansia.show', compact('lansia', 'chartData'));
    }

    public function edit(Lansia $lansia)
    {
        $this->authorize('update', $lansia);
        return view('warga.lansia.edit', compact('lansia'));
    }

    public function update(LansiaRequest $request, Lansia $lansia)
    {
        $this->authorize('update', $lansia);

        $this->lansiaService->updateLansia(
            $lansia,
            $request->except('foto'),
            $request->hasFile('foto') ? $request->file('foto') : null
        );

        return redirect()->route('warga.lansia.index')
            ->with('success', 'Data lansia berhasil diperbarui.');
    }

    public function showPemeriksaan(PemeriksaanLansia $pemeriksaan)
    {
        $this->authorize('view', $pemeriksaan->lansia);
        $pemeriksaan->load(['lansia', 'user']);
        return view('warga.lansia.pemeriksaan-show', compact('pemeriksaan'));
    }
}