<?php
// app/Http/Controllers/Warga/KehamilanController.php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Http\Requests\KehamilanRequest;
use App\Models\Kehamilan;
use App\Services\KehamilanService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class KehamilanController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private KehamilanService $service) {}

    public function index()
    {
        $user   = Auth::user();
        $warga  = $user->warga;

        if (!$warga) {
            return redirect()->route('warga.warga.create')
                ->with('warning', 'Silakan lengkapi data warga terlebih dahulu.');
        }

        $data = $this->service->getWargaDashboard($warga->id);

        return view('warga.kehamilan.index', $data);
    }

    public function create()
    {
        return view('warga.kehamilan.create');
    }

    public function store(KehamilanRequest $request)
    {
        $warga = Auth::user()->warga;
        if (!$warga) {
            return redirect()->route('warga.warga.create')
                ->with('warning', 'Silakan lengkapi data warga terlebih dahulu.');
        }

        $validated        = $request->validated();
        $validated['warga_id'] = $warga->id;

        $this->service->storeKehamilan($validated, $request->file('foto'));

        return redirect()->route('warga.kehamilan.index')
            ->with('success', 'Data kehamilan berhasil ditambahkan. Menunggu verifikasi Pegawai.');
    }

    public function show(Kehamilan $kehamilan)
    {
        $this->authorize('view', $kehamilan);
        $kehamilan->load(['anc.user', 'konsumsiTtd', 'warga']);

        $chartData = $this->service->getChartData($kehamilan);

        return view('warga.kehamilan.show', compact('kehamilan', 'chartData'));
    }

    public function edit(Kehamilan $kehamilan)
    {
        $this->authorize('update', $kehamilan);

        if ($kehamilan->is_verified) {
            return redirect()->route('warga.kehamilan.index')
                ->with('warning', 'Data yang telah diverifikasi tidak dapat diubah.');
        }

        return view('warga.kehamilan.edit', compact('kehamilan'));
    }

    public function update(KehamilanRequest $request, Kehamilan $kehamilan)
    {
        $this->authorize('update', $kehamilan);

        if ($kehamilan->is_verified) {
            return redirect()->route('warga.kehamilan.index')
                ->with('warning', 'Data yang telah diverifikasi tidak dapat diubah.');
        }

        $this->service->updateKehamilan($kehamilan, $request->validated(), $request->file('foto'));

        return redirect()->route('warga.kehamilan.index')
            ->with('success', 'Data kehamilan berhasil diperbarui.');
    }
}
