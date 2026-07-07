<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WargaController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Warga::with(['user', 'verifiedBy']);

        // Filter status
        if ($request->filled('status')) {
            $query->where('verification_status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $warga = $query->paginate(10);

        // Stats
        $stats = [
            'total' => Warga::count(),
            'laki_laki' => Warga::where('jenis_kelamin', 'L')->count(),
            'perempuan' => Warga::where('jenis_kelamin', 'P')->count(),
        ];
        $routePrefix = 'kader.warga.';
        
        $provinsiList = \App\Models\Wilayah::where('tingkat', 'provinsi')->get();

        return view('warga.index', compact('warga', 'stats', 'routePrefix', 'provinsiList'));
    }

    public function show(Warga $warga)
    {
        $warga->load([
            'user',
            'verifiedBy',
            'balita' => function ($query) {
                $query->with([
                    'pelayanan' => function ($q) {
                        $q->latest()->take(1);
                    }
                ]);
            },
            'provinsi',
            'kabupaten',
            'kecamatan',
            'kelurahan'
        ]);

        $stats = [
            'jumlah_balita' => $warga->balita->count(),
            'kehadiran' => $warga->balita->sum(function ($balita) {
                return $balita->pelayanan->count();
            }),
            'pelayanan_terakhir' => $warga->balita->flatMap(function ($balita) {
                return $balita->pelayanan;
            })->sortByDesc('created_at')->first(),
        ];
        $routePrefix = 'kader.warga.';

        return view('warga.show', compact('warga', 'stats', 'routePrefix'));
    }

    public function verify(Warga $warga)
    {
        $warga->verification_status = 'verified';
        $warga->verified_by = Auth::id();
        $warga->verified_at = now();
        $warga->rejected_reason = null;
        $warga->save();

        return redirect()->back()
            ->with('success', 'Data warga berhasil diverifikasi.');
    }

    public function reject(Request $request, Warga $warga)
    {
        $request->validate([
            'rejected_reason' => ['required', 'string', 'min:10'],
        ]);

        $warga->verification_status = 'rejected';
        $warga->rejected_reason = $request->rejected_reason;
        $warga->verified_by = Auth::id();
        $warga->verified_at = now();
        $warga->save();

        return redirect()->back()
            ->with('success', 'Data warga berhasil ditolak.');
    }
}
