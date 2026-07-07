<?php

use App\Models\Balita;
use App\Models\KegiatanPosyandu;
use App\Models\User;

it('renders the kegiatan detail page when a balita has no linked warga record', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);

    $kegiatan = KegiatanPosyandu::factory()->create([
        'user_id' => $admin->id,
        'jam_mulai' => '08:00:00',
        'jam_selesai' => '10:00:00',
    ]);
    $kegiatan->setRelation('user', $admin);

    $balita = new Balita(['id' => 1, 'nama' => 'Budi']);
    $balita->setRelation('warga', null);

    $this->actingAs($admin);

    $view = view('kegiatan.show', [
        'kegiatan' => $kegiatan,
        'peserta' => collect([
            [
                'balita' => $balita,
                'hadir' => true,
                'pelayanan' => null,
            ],
        ]),
        'summary' => [
            'total_balita' => 1,
            'hadir' => 1,
            'tidak_hadir' => 0,
            'pelayanan_selesai' => 1,
        ],
        'nutritionSummary' => [
            'normal' => 0,
            'kurang' => 0,
            'buruk' => 0,
            'lebih' => 0,
            'vitamin' => 0,
            'imunisasi' => 0,
        ],
        'timeline' => [],
    ]);

    $html = $view->render();

    expect($html)->toContain('Tidak tersedia');
});
