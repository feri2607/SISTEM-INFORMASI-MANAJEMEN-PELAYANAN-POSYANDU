<?php
// app/Services/CitizenCategoryService.php

namespace App\Services;

use App\Models\Warga;

class CitizenCategoryService
{
    // =============================================
    // Batas Usia Kategori
    // =============================================

    const REMAJA_MIN  = 10;
    const REMAJA_MAX  = 24;
    const LANSIA_MIN  = 60;
    const WUS_MIN     = 15;
    const WUS_MAX     = 49;
    const PUS_MIN     = 15;
    const PUS_MAX     = 49;

    // =============================================
    // Penentu Kategori Individual
    // =============================================

    /**
     * Apakah warga memiliki anak yang masuk kategori Balita (< 5 tahun)?
     * Dihitung langsung dari tabel anak — tidak ada kolom statis.
     */
    public function hasBalita(Warga $warga): bool
    {
        return $warga->anak()->balita()->exists();
    }

    /**
     * Apakah warga termasuk Remaja (usia 10–24 tahun)?
     */
    public function isRemaja(Warga $warga): bool
    {
        $umur = $warga->tanggal_lahir?->age ?? 0;
        return $umur >= self::REMAJA_MIN && $umur <= self::REMAJA_MAX;
    }

    /**
     * Apakah warga termasuk Lansia (usia >= 60 tahun)?
     */
    public function isLansia(Warga $warga): bool
    {
        $umur = $warga->tanggal_lahir?->age ?? 0;
        return $umur >= self::LANSIA_MIN;
    }

    /**
     * Apakah warga termasuk WUS — Wanita Usia Subur (perempuan, usia 15–49)?
     */
    public function isWUS(Warga $warga): bool
    {
        $umur = $warga->tanggal_lahir?->age ?? 0;
        return $warga->jenis_kelamin === 'P'
            && $umur >= self::WUS_MIN
            && $umur <= self::WUS_MAX;
    }

    /**
     * Apakah warga termasuk PUS — Pasangan Usia Subur?
     * Syarat: status pernikahan = kawin DAN usia produktif (15–49 tahun).
     */
    public function isPUS(Warga $warga): bool
    {
        $umur = $warga->tanggal_lahir?->age ?? 0;

        $statusKawin = in_array($warga->status_pernikahan, [
            'kawin',
            'Kawin',
            'menikah',
            'Menikah',
        ]);

        return $statusKawin
            && $umur >= self::PUS_MIN
            && $umur <= self::PUS_MAX;
    }

    /**
     * Apakah warga sedang hamil? Berdasarkan kolom status_kehamilan.
     */
    public function isKehamilan(Warga $warga): bool
    {
        return $warga->status_kehamilan === 'ya';
    }

    /**
     * Apakah warga sedang menyusui? Berdasarkan kolom status_menyusui.
     */
    public function isMenyusui(Warga $warga): bool
    {
        return $warga->status_menyusui === 'ya';
    }

    // =============================================
    // Kumpulan Kategori
    // =============================================

    /**
     * Kembalikan array semua kategori yang dimiliki warga.
     *
     * @return array<string>
     * Contoh: ['balita', 'wus', 'kehamilan']
     */
    public function getCategories(Warga $warga): array
    {
        $categories = [];

        if ($this->hasBalita($warga))    $categories[] = 'balita';
        if ($this->isRemaja($warga))     $categories[] = 'remaja';
        if ($this->isLansia($warga))     $categories[] = 'lansia';
        if ($this->isWUS($warga))        $categories[] = 'wus';
        if ($this->isPUS($warga))        $categories[] = 'pus';
        if ($this->isKehamilan($warga))  $categories[] = 'kehamilan';
        if ($this->isMenyusui($warga))   $categories[] = 'menyusui';

        return $categories;
    }

    // =============================================
    // Menu Dashboard
    // =============================================

    /**
     * Kembalikan daftar menu layanan untuk dashboard warga.
     * Setiap item berisi: icon, label, route, color, description.
     *
     * @return array<int, array{icon: string, label: string, route: string, color: string, description: string}>
     */
    public function getDashboardMenus(Warga $warga): array
    {
        $menus = [];

        if ($this->hasBalita($warga)) {
            $menus[] = [
                'key'         => 'balita',
                'icon'        => 'user-group',
                'label'       => 'Posyandu Balita',
                'description' => 'Pemantauan tumbuh kembang dan imunisasi',
                'route'       => route('warga.balita.index'),
                'color'       => 'blue',
                'bg'          => 'bg-blue-50',
                'text'        => 'text-blue-600',
                'border'      => 'border-blue-200',
            ];
        }

        if ($this->isKehamilan($warga)) {
            $menus[] = [
                'key'         => 'kehamilan',
                'icon'        => 'heart',
                'label'       => 'Kehamilan',
                'description' => 'Pemeriksaan ANC dan pantau kehamilan',
                'route'       => route('warga.kehamilan.index'),
                'color'       => 'pink',
                'bg'          => 'bg-pink-50',
                'text'        => 'text-pink-600',
                'border'      => 'border-pink-200',
            ];
        }

        if ($this->isMenyusui($warga)) {
            $menus[] = [
                'key'         => 'menyusui',
                'icon'        => 'sparkles',
                'label'       => 'Menyusui',
                'description' => 'Dukungan dan konseling laktasi',
                'route'       => route('warga.kehamilan.index'),
                'color'       => 'purple',
                'bg'          => 'bg-purple-50',
                'text'        => 'text-purple-600',
                'border'      => 'border-purple-200',
            ];
        }

        if ($this->isRemaja($warga)) {
            $menus[] = [
                'key'         => 'remaja',
                'icon'        => 'academic-cap',
                'label'       => 'Posyandu Remaja',
                'description' => 'Pemeriksaan kesehatan remaja',
                'route'       => route('warga.remaja.index'),
                'color'       => 'green',
                'bg'          => 'bg-green-50',
                'text'        => 'text-green-600',
                'border'      => 'border-green-200',
            ];
        }

        if ($this->isLansia($warga)) {
            $menus[] = [
                'key'         => 'lansia',
                'icon'        => 'shield-check',
                'label'       => 'Posyandu Lansia',
                'description' => 'Pemeriksaan tekanan darah dan kesehatan lansia',
                'route'       => route('warga.lansia.index'),
                'color'       => 'orange',
                'bg'          => 'bg-orange-50',
                'text'        => 'text-orange-600',
                'border'      => 'border-orange-200',
            ];
        }

        if ($this->isWUS($warga) || $this->isPUS($warga)) {
            $menus[] = [
                'key'         => 'wus',
                'icon'        => 'beaker',
                'label'       => 'Kesehatan Reproduksi',
                'description' => 'Skrining dan pelayanan WUS/PUS',
                'route'       => route('warga.reproduksi.index'),
                'color'       => 'teal',
                'bg'          => 'bg-teal-50',
                'text'        => 'text-teal-600',
                'border'      => 'border-teal-200',
            ];
        }

        return $menus;
    }

    // =============================================
    // Kontrol Akses Modul
    // =============================================

    /**
     * Kembalikan daftar modul/route yang boleh diakses warga.
     *
     * @return array<string>
     * Contoh: ['balita', 'kehamilan', 'wus']
     */
    public function getAccessibleModules(Warga $warga): array
    {
        $modules = [];

        if ($this->hasBalita($warga))               $modules[] = 'balita';
        if ($this->isRemaja($warga))                $modules[] = 'remaja';
        if ($this->isLansia($warga))                $modules[] = 'lansia';
        if ($this->isWUS($warga) || $this->isPUS($warga)) $modules[] = 'reproduksi';
        if ($this->isKehamilan($warga))             $modules[] = 'kehamilan';
        if ($this->isMenyusui($warga))              $modules[] = 'menyusui';

        return $modules;
    }

    /**
     * Cek apakah warga boleh mengakses modul tertentu.
     *
     * @param string $module Nama modul, contoh: 'balita', 'remaja', 'lansia', 'reproduksi', 'kehamilan'
     */
    public function canAccessModule(Warga $warga, string $module): bool
    {
        return in_array($module, $this->getAccessibleModules($warga));
    }

    // =============================================
    // Auto Populate & Sync Data
    // =============================================

    /**
     * Sinkronisasi data warga ke tabel-tabel rekam medis sesuai kategorinya.
     */
    public function syncData(Warga $warga): void
    {
        if ($this->isLansia($warga)) {
            $this->syncLansiaData($warga);
        }
        if ($this->isRemaja($warga)) {
            $this->syncRemajaData($warga);
        }
        if ($this->isWUS($warga)) {
            $this->syncWusData($warga);
        }
        if ($this->isPUS($warga)) {
            $this->syncPusData($warga);
        }
        if ($this->isKehamilan($warga)) {
            $this->syncKehamilanData($warga);
        }
    }

    /**
     * Auto-populate ke tabel lansia
     */
    protected function syncLansiaData(Warga $warga): void
    {
        $lansia = \App\Models\Lansia::firstOrNew(['warga_id' => $warga->id]);
        
        $lansia->fill([
            'nama' => $warga->nama,
            'nik' => $warga->nik,
            'tanggal_lahir' => $warga->tanggal_lahir,
            'umur' => $warga->tanggal_lahir?->age,
            'jenis_kelamin' => $warga->jenis_kelamin,
            'alamat' => $warga->alamat,
            'golongan_darah' => $warga->golongan_darah,
            'riwayat_penyakit' => $warga->catatan_kesehatan, // Asumsi ini relevan
            'no_hp' => $warga->telepon,
            // 'foto' biarkan manual, atau tidak ditimpa jika sudah ada
            'is_verified' => $warga->verification_status === 'verified',
            'verified_by' => $warga->verified_by,
            'verified_at' => $warga->verified_at,
        ]);
        
        $lansia->save();
    }

    /**
     * Auto-populate ke tabel remaja
     */
    protected function syncRemajaData(Warga $warga): void
    {
        $remaja = \App\Models\Remaja::firstOrNew(['warga_id' => $warga->id]);
        
        $remaja->fill([
            'nama' => $warga->nama,
            'nik' => $warga->nik,
            'tanggal_lahir' => $warga->tanggal_lahir,
            'jenis_kelamin' => $warga->jenis_kelamin,
            'no_hp' => $warga->telepon,
            'alamat' => $warga->alamat,
            'is_verified' => $warga->verification_status === 'verified',
            'verified_by' => $warga->verified_by,
            'verified_at' => $warga->verified_at,
        ]);
        
        $remaja->save();
    }

    /**
     * Auto-populate ke tabel WUS (Wanita Usia Subur)
     */
    protected function syncWusData(Warga $warga): void
    {
        $wus = \App\Models\Wus::firstOrNew(['warga_id' => $warga->id]);
        
        $wus->fill([
            'nama' => $warga->nama,
            'nik' => $warga->nik,
            'tanggal_lahir' => $warga->tanggal_lahir,
            'status_pernikahan' => $warga->status_pernikahan,
            'alamat' => $warga->alamat,
            'no_hp' => $warga->telepon,
            'is_verified' => $warga->verification_status === 'verified',
            'verified_by' => $warga->verified_by,
            'verified_at' => $warga->verified_at,
        ]);
        
        $wus->save();
    }

    /**
     * Auto-populate ke tabel PUS (Pasangan Usia Subur)
     */
    protected function syncPusData(Warga $warga): void
    {
        $pus = \App\Models\Pus::firstOrNew(['warga_id' => $warga->id]);
        
        $pus->fill([
            'nama_pasangan' => '-', // Dummy, karena diisi saat pelayanan manual
            'jumlah_anak' => $warga->anak()->count(),
            'status_kb' => 'tidak_aktif',
        ]);
        
        $pus->save();
    }

    /**
     * Auto-populate ke tabel Kehamilan
     */
    protected function syncKehamilanData(Warga $warga): void
    {
        // Hanya buat jika belum ada data kehamilan sama sekali untuk warga ini
        $kehamilan = \App\Models\Kehamilan::firstOrNew(['warga_id' => $warga->id]);
        
        $kehamilan->fill([
            'nama' => $warga->nama,
            'nik' => $warga->nik,
            'tanggal_lahir' => $warga->tanggal_lahir,
            'no_hp' => $warga->telepon,
            'alamat' => $warga->alamat,
            'is_verified' => $warga->verification_status === 'verified',
            'verified_by' => $warga->verified_by,
            'verified_at' => $warga->verified_at,
        ]);
        
        $kehamilan->save();
    }
}
