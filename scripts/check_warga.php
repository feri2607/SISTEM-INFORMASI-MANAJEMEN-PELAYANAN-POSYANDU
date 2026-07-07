<?php
// scripts/check_warga.php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Warga;

$id = $argv[1] ?? null;
if (!$id) {
    echo "Usage: php scripts/check_warga.php <id>\n";
    exit(1);
}

$warga = Warga::withTrashed()->find($id);
if (!$warga) {
    echo "No warga found with id={$id}\n";
    exit(0);
}

echo "Warga id={$id}:\n";
echo "  nama: " . ($warga->nama ?? 'NULL') . "\n";
echo "  nik: " . ($warga->nik ?? 'NULL') . "\n";
echo "  deleted_at: " . ($warga->deleted_at ?? 'NULL') . "\n";

// show related counts for key related models
$related = [\App\Models\Balita::class, \App\Models\Kehamilan::class, \App\Models\Remaja::class, \App\Models\Lansia::class, \App\Models\Wus::class, \App\Models\Pus::class, \App\Models\SkriningReproduksi::class];
foreach ($related as $r) {
    try {
        $model = new $r;
        $count = $model->newQuery()->where('warga_id', $id)->count();
        echo "  " . class_basename($r) . " count: " . $count . "\n";
    } catch (\Throwable $e) {
        echo "  " . class_basename($r) . " error: " . $e->getMessage() . "\n";
    }
}
