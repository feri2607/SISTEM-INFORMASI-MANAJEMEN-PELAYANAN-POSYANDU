<?php
// app/Http/Controllers/Admin/WargaController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warga;
use App\Models\User;
use App\Http\Requests\WargaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WargaController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Warga::class);

        $query = Warga::with(['user', 'verifiedBy']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('nomor_kk', 'like', "%{$search}%");
            });
        }

        // Filter gender
        if ($request->filled('gender')) {
            $query->where('jenis_kelamin', $request->gender);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('verification_status', $request->status);
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $warga = $query->paginate(10);

        // Stats
        $stats = [
            'total'     => Warga::count(),
            'laki_laki' => Warga::where('jenis_kelamin', 'L')->count(),
            'perempuan' => Warga::where('jenis_kelamin', 'P')->count(),
            'verified'  => Warga::where('verification_status', 'verified')->count(),
        ];
        $routePrefix = Auth::user()->role === 'admin' ? 'admin.warga.' : 'pegawai.warga.';

        $provinsiList = \App\Models\Wilayah::where('tingkat', 'provinsi')->get();

        return view('Admin.warga.index', compact('warga', 'stats', 'routePrefix', 'provinsiList'));
    }

    public function show(Warga $warga)
    {
        $this->authorize('view', $warga);

        $warga->load([
            'user',
            'verifiedBy',
            'balita' => function ($query) {
                $query->with([
                    'pelayanan' => function ($q) {
                        $q->latest()->take(1);
                    }
                ]);
            }
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
        $routePrefix = Auth::user()->role === 'admin' ? 'admin.warga.' : 'pegawai.warga.';

        return view('Admin.warga.show', compact('warga', 'stats', 'routePrefix'));
    }

    public function create()
    {
        $this->authorize('create', Warga::class);

        $users = User::where('role', 'user')->get();
        $provinsi = \App\Models\Wilayah::where('tingkat', 'provinsi')->get();
        $statusPerkawinan = [
            'belum_kawin' => 'Belum Kawin',
            'kawin' => 'Kawin',
            'cerai_hidup' => 'Cerai Hidup',
            'cerai_mati' => 'Cerai Mati',
        ];

        $routePrefix = Auth::user()->role === 'admin' ? 'admin.warga.' : 'pegawai.warga.';

        return view('Admin.warga.create', compact('users', 'provinsi', 'statusPerkawinan', 'routePrefix'));
    }

    public function store(WargaRequest $request)
    {
        $this->authorize('create', Warga::class);

        $data = $request->validated();
        
        // 1. Generate random password (8 chars)
        $tempPassword = Str::random(8);

        // 2. Create User account automatically (NIK as email/username)
        // If they entered an email, we can save it, but the login field is 'email' column, 
        // so we save NIK into 'email' column so they can log in using NIK.
        // We'll append an identifier or just use NIK directly. Actually, NIK is safest.
        $userWarga = User::updateOrCreate(
            ['email' => $data['nik']], // use NIK as the login identifier
            [
                'name' => $data['nama'],
                'password' => Hash::make($tempPassword),
                'role' => 'user', 
                'email_verified_at' => now(), // Auto verify since created by admin
            ]
        );

        $data['user_id'] = $userWarga->id;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('foto-warga', $filename, 'public');
            $data['foto'] = $filename;
        }

        $warga = Warga::create($data);

        return redirect()->route(Auth::user()->role === 'admin' ? 'admin.warga.index' : 'pegawai.warga.index')
            ->with('success', 'Data warga berhasil ditambahkan.')
            ->with('warga_created', [
                'nama' => $userWarga->name,
                'nik' => $data['nik'],
                'password_sementara' => $tempPassword
            ]);
    }

    public function edit(Warga $warga)
    {
        $this->authorize('update', $warga);

        $users = User::where('role', 'user')->get();
        $provinsi = \App\Models\Wilayah::where('tingkat', 'provinsi')->get();
        $kabupaten = \App\Models\Wilayah::where('tingkat', 'kabupaten')
            ->where('parent_id', $warga->provinsi_id)
            ->get();
        $kecamatan = \App\Models\Wilayah::where('tingkat', 'kecamatan')
            ->where('parent_id', $warga->kabupaten_id)
            ->get();
        $kelurahan = \App\Models\Wilayah::where('tingkat', 'kelurahan')
            ->where('parent_id', $warga->kecamatan_id)
            ->get();

        $statusPerkawinan = [
            'belum_kawin' => 'Belum Kawin',
            'kawin' => 'Kawin',
            'cerai_hidup' => 'Cerai Hidup',
            'cerai_mati' => 'Cerai Mati',
        ];

        $routePrefix = Auth::user()->role === 'admin' ? 'admin.warga.' : 'pegawai.warga.';

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

    public function update(WargaRequest $request, Warga $warga)
    {
        $this->authorize('update', $warga);

        if ($request->has('action_reset_password')) {
            if (!$warga->user) {
                return back()->with('error', 'Warga ini belum memiliki akun login.');
            }
            
            $tempPassword = Str::random(8);
            $warga->user->update([
                'password' => Hash::make($tempPassword)
            ]);
            
            return back()->with('warga_created', [
                'nama' => $warga->nama,
                'nik' => $warga->nik,
                'password_sementara' => $tempPassword
            ])->with('success', 'Berhasil mereset password warga.');
        }

        $data = $request->validated();

        // Upload KTP
        if ($request->hasFile('ktp_path')) {
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

        $warga->update($data);

        return redirect()->route(Auth::user()->role === 'admin' ? 'admin.warga.index' : 'pegawai.warga.index')
            ->with('success', 'Data warga berhasil diperbarui.');
    }

    public function destroy(Warga $warga)
    {
        $this->authorize('delete', $warga);

        try {
            DB::transaction(function () use ($warga) {
                $this->deleteRelatedWargaData($warga);

                if ($warga->ktp_path && Storage::disk('public')->exists($warga->ktp_path)) {
                    Storage::disk('public')->delete($warga->ktp_path);
                }
                if ($warga->kk_path && Storage::disk('public')->exists($warga->kk_path)) {
                    Storage::disk('public')->delete($warga->kk_path);
                }

                if ($warga->foto && Storage::disk('public')->exists('foto-warga/' . $warga->foto)) {
                    Storage::disk('public')->delete('foto-warga/' . $warga->foto);
                }

                $warga->forceDelete();
            });

            return redirect()->route(Auth::user()->role === 'admin' ? 'admin.warga.index' : 'pegawai.warga.index')
                ->with('success', 'Data warga berhasil dihapus secara permanen.');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Gagal hapus warga (Admin)', [
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
     * Export to Excel
     */
    public function exportExcel(Request $request)
    {
        // Implement Excel export
        return back()->with('info', 'Fitur export Excel sedang dalam pengembangan.');
    }

    /**
     * Export to PDF
     */
    public function exportPdf(Request $request)
    {
        // Implement PDF export
        return back()->with('info', 'Fitur export PDF sedang dalam pengembangan.');
    }
}