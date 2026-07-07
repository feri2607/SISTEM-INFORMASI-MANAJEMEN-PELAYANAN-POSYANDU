<?php

namespace App\Http\Controllers;

use App\Http\Requests\PelayananRequest;
use App\Models\Balita;
use App\Models\HasilPelayanan;
use App\Models\KegiatanPosyandu;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelayananController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = HasilPelayanan::with(['kegiatan', 'balita.warga', 'user']);

        if ($user->role === 'user') {
            $query->whereHas('balita.warga', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('balita', fn ($b) => $b->where('nama', 'like', "%{$search}%"))
                    ->orWhereHas('kegiatan', fn ($k) => $k->where('nama_kegiatan', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status_gizi')) {
            $query->where('status_gizi', $request->status_gizi);
        }

        $pelayanan = $query->latest()->paginate(10);
        $routePrefix = $user->role . '.pelayanan.';

        return view('pelayanan.index', compact('pelayanan', 'routePrefix'));
    }

    public function create(Request $request)
    {
        $this->authorize('create', HasilPelayanan::class);

        $user = Auth::user();
        $routePrefix = $user->role . '.pelayanan.';

        $kegiatanList = KegiatanPosyandu::when($user->role === 'user', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->orderByDesc('tanggal')->get();

        $balitaList = Balita::with('warga')->when($user->role === 'user', function ($q) use ($user) {
            $q->whereHas('warga', fn ($w) => $w->where('user_id', $user->id));
        })->orderBy('nama')->get();

        $selectedKegiatan = $request->filled('kegiatan_id')
            ? KegiatanPosyandu::find($request->kegiatan_id)
            : null;

        $selectedBalita = $request->filled('balita_id')
            ? Balita::with('warga')->find($request->balita_id)
            : null;

        return view('pelayanan.create', compact(
            'kegiatanList',
            'balitaList',
            'selectedKegiatan',
            'selectedBalita',
            'routePrefix'
        ));
    }

    public function store(PelayananRequest $request)
    {
        $this->authorize('create', HasilPelayanan::class);

        $data = $request->validated();
        $data['user_id'] = Auth::id();

        HasilPelayanan::create($data);

        $routePrefix = Auth::user()->role . '.pelayanan.';

        return redirect()->route($routePrefix . 'index')
            ->with('success', 'Hasil pelayanan berhasil disimpan.');
    }

    public function show(HasilPelayanan $pelayanan)
    {
        $this->authorize('view', $pelayanan);

        $pelayanan->load(['kegiatan', 'balita.warga', 'user']);
        $routePrefix = Auth::user()->role . '.pelayanan.';

        return view('pelayanan.show', compact('pelayanan', 'routePrefix'));
    }

    public function edit(HasilPelayanan $pelayanan)
    {
        $this->authorize('update', $pelayanan);

        $user = Auth::user();
        $routePrefix = $user->role . '.pelayanan.';

        $kegiatanList = KegiatanPosyandu::when($user->role === 'user', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->orderByDesc('tanggal')->get();

        $balitaList = Balita::with('warga')->when($user->role === 'user', function ($q) use ($user) {
            $q->whereHas('warga', fn ($w) => $w->where('user_id', $user->id));
        })->orderBy('nama')->get();

        return view('pelayanan.edit', compact('pelayanan', 'kegiatanList', 'balitaList', 'routePrefix'));
    }

    public function update(PelayananRequest $request, HasilPelayanan $pelayanan)
    {
        $this->authorize('update', $pelayanan);

        $pelayanan->update($request->validated());

        $routePrefix = Auth::user()->role . '.pelayanan.';

        return redirect()->route($routePrefix . 'index')
            ->with('success', 'Hasil pelayanan berhasil diperbarui.');
    }

    public function destroy(HasilPelayanan $pelayanan)
    {
        $this->authorize('delete', $pelayanan);

        $pelayanan->delete();

        $routePrefix = Auth::user()->role . '.pelayanan.';

        return redirect()->route($routePrefix . 'index')
            ->with('success', 'Hasil pelayanan berhasil dihapus.');
    }
}
