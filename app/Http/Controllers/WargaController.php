<?php
// app/Http/Controllers/WargaController.php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\User;
use App\Models\Wilayah;
use App\Http\Requests\WargaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Warga::with(['user', 'balita']);

        // Kader only sees their own warga
        if ($user->role === 'user') {
            $query->where('user_id', $user->id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('no_telepon', 'like', "%{$search}%");
            });
        }

        // Filter by gender
        if ($request->filled('gender')) {
            $query->where('jenis_kelamin', $request->gender);
        }

        // Filter by wilayah
        if ($request->filled('provinsi')) {
            $query->where('provinsi_id', $request->provinsi);
        }
        if ($request->filled('kabupaten')) {
            $query->where('kabupaten_id', $request->kabupaten);
        }
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan_id', $request->kecamatan);
        }
        if ($request->filled('kelurahan')) {
            $query->where('kelurahan_id', $request->kelurahan);
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $warga = $query->paginate(10);

        // Stats
        $stats = [
            'total' => Warga::when($user->role === 'user', function ($q) use ($user) {
                return $q->where('user_id', $user->id);
            })->count(),
            'laki_laki' => Warga::when($user->role === 'user', function ($q) use ($user) {
                return $q->where('user_id', $user->id);
            })->where('jenis_kelamin', 'L')->count(),
            'perempuan' => Warga::when($user->role === 'user', function ($q) use ($user) {
                return $q->where('user_id', $user->id);
            })->where('jenis_kelamin', 'P')->count(),
        ];

        // Get wilayah for filters
        $provinsiList = Wilayah::where('tingkat', 'provinsi')->get();
        $routePrefix = $user->role . '.warga.';

        return view('Admin.warga.index', compact('warga', 'stats', 'provinsiList', 'routePrefix'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Warga::class);

        $users = Auth::user()->role === 'admin' ? User::where('role', 'user')->get() : null;
        $provinsi = Wilayah::where('tingkat', 'provinsi')->get();
        $statusPerkawinan = [
            'belum_kawin' => 'Belum Kawin',
            'kawin' => 'Kawin',
            'cerai_hidup' => 'Cerai Hidup',
            'cerai_mati' => 'Cerai Mati',
        ];
        $routePrefix = Auth::user()->role . '.warga.';

        return view('Admin.warga.create', compact('users', 'provinsi', 'statusPerkawinan', 'routePrefix'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WargaRequest $request)
    {
        $this->authorize('create', Warga::class);

        $data = $request->validated();
        $data['user_id'] = $request->user_id ?? Auth::id();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('foto-warga', $filename, 'public');
            $data['foto'] = $filename;
        }

        $warga = Warga::create($data);

        return redirect()->route(Auth::user()->role . '.warga.index')
            ->with('success', 'Data warga berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Warga $warga)
    {
        $this->authorize('view', $warga);

        $warga->load([
            'user',
            'balita' => function ($query) {
                $query->with([
                    'pelayanan' => function ($q) {
                        $q->latest()->take(1);
                    }
                ]);
            }
        ]);

        // Get statistics
        $stats = [
            'jumlah_balita' => $warga->balita->count(),
            'kehadiran' => $warga->balita->sum(function ($balita) {
                return $balita->pelayanan->count();
            }),
            'pelayanan_terakhir' => $warga->balita->flatMap(function ($balita) {
                return $balita->pelayanan;
            })->sortByDesc('created_at')->first(),
        ];
        $routePrefix = Auth::user()->role . '.warga.';

        return view('Admin.warga.show', compact('warga', 'stats', 'routePrefix'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warga $warga)
    {
        $this->authorize('update', $warga);

        $users = Auth::user()->role === 'admin' ? User::where('role', 'user')->get() : null;
        $provinsi = Wilayah::where('tingkat', 'provinsi')->get();
        $kabupaten = Wilayah::where('tingkat', 'kabupaten')
            ->where('parent_id', $warga->provinsi_id)
            ->get();
        $kecamatan = Wilayah::where('tingkat', 'kecamatan')
            ->where('parent_id', $warga->kabupaten_id)
            ->get();
        $kelurahan = Wilayah::where('tingkat', 'kelurahan')
            ->where('parent_id', $warga->kecamatan_id)
            ->get();

        $statusPerkawinan = [
            'belum_kawin' => 'Belum Kawin',
            'kawin' => 'Kawin',
            'cerai_hidup' => 'Cerai Hidup',
            'cerai_mati' => 'Cerai Mati',
        ];
        $routePrefix = Auth::user()->role . '.warga.';

        return view('Admin.warga.edit', compact(
            'warga',
            'users',
            'provinsi',
            'kabupaten',
            'kecamatan',
            'kelurahan',
            'statusPerkawinan',
            'routePrefix'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WargaRequest $request, Warga $warga)
    {
        $this->authorize('update', $warga);

        $data = $request->validated();

        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($warga->foto && Storage::disk('public')->exists('foto-warga/' . $warga->foto)) {
                Storage::disk('public')->delete('foto-warga/' . $warga->foto);
            }

            $file = $request->file('foto');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('foto-warga', $filename, 'public');
            $data['foto'] = $filename;
        }

        $warga->update($data);

        return redirect()->route(Auth::user()->role . '.warga.index')
            ->with('success', 'Data warga berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warga $warga)
    {
        $this->authorize('delete', $warga);

        Log::info('WargaController@destroy called', ['warga_id' => $warga->id, 'user_id' => Auth::id()]);

        try {
            DB::transaction(function () use ($warga) {
                Log::info('WargaController@destroy transaction start', ['warga_id' => $warga->id]);
                $this->deleteRelatedWargaData($warga);

                if ($warga->foto && Storage::disk('public')->exists('foto-warga/' . $warga->foto)) {
                    Storage::disk('public')->delete('foto-warga/' . $warga->foto);
                }

                $warga->forceDelete();
                Log::info('WargaController@destroy forceDelete called', ['warga_id' => $warga->id]);
            });

            return redirect()->route(Auth::user()->role . '.warga.index')
                ->with('success', 'Data warga berhasil dihapus secara permanen.');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Gagal hapus warga (Pegawai)', [
                'warga_id' => $warga->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    protected function deleteRelatedWargaData(Warga $warga): void
    {
        $relatedModels = [
            \App\Models\Balita::class,
            \App\Models\Kehamilan::class,
            \App\Models\Remaja::class,
            \App\Models\Lansia::class,
            \App\Models\Wus::class,
            \App\Models\Pus::class,
            \App\Models\SkriningReproduksi::class,
        ];

        foreach ($relatedModels as $modelClass) {
            $model = new $modelClass;
            if (Schema::hasTable($model->getTable())) {
                $records = $model->newQuery()->where('warga_id', $warga->id)->get();

                // If model uses SoftDeletes, perform permanent delete to avoid
                // leaving referencing rows that block parent deletion by calling Model instance directly to trigger events
                foreach ($records as $record) {
                    if (method_exists($record, 'forceDelete')) {
                        $record->forceDelete();
                    } else {
                        $record->delete();
                    }
                }
            }
        }
    }

    /**
     * Verify Warga
     */
    public function verify(Warga $warga)
    {
        $this->authorize('verify', $warga);

        $warga->verification_status = 'verified';
        $warga->verified_by = Auth::id();
        $warga->verified_at = now();
        $warga->rejected_reason = null;
        $warga->save();

        return redirect()->back()
            ->with('success', 'Data warga berhasil diverifikasi.');
    }

    /**
     * Reject Warga
     */
    public function reject(Request $request, Warga $warga)
    {
        $this->authorize('reject', $warga);

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

    /**
     * Get wilayah by parent
     */
    public function getWilayah(Request $request)
    {
        $parentId = $request->parent_id;
        $tingkat = $request->tingkat;

        $wilayah = Wilayah::where('parent_id', $parentId)
            ->where('tingkat', $tingkat)
            ->get();

        return response()->json($wilayah);
    }

    /**
     * Export to Excel
     */
    public function exportExcel(Request $request)
    {
        // Implement Excel export
        // return Excel::download(new WargaExport($request), 'warga.xlsx');
    }

    /**
     * Export to PDF
     */
    public function exportPdf(Request $request)
    {
        // Implement PDF export
        // $warga = Warga::get();
        // $pdf = PDF::loadView('warga.pdf', compact('warga'));
        // return $pdf->download('warga.pdf');
    }
}