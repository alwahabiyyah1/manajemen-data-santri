<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$ds = App\Models\DataSantri::where('id_santri', 12)->first();
echo "foto_3x4: " . ($ds->foto_3x4 ?? 'NULL') . "\n";
echo "foto_kk: " . ($ds->foto_kk ?? 'NULL') . "\n";

// Check which path exists
if ($ds->foto_3x4) {
    $path1 = public_path('storage/' . $ds->foto_3x4);
    $path2 = public_path('storage/berkas/' . $ds->foto_3x4);
    echo "Path 'storage/{foto}' exists: " . (file_exists($path1) ? 'YES' : 'NO') . " -> $path1\n";
    echo "Path 'storage/berkas/{foto}' exists: " . (file_exists($path2) ? 'YES' : 'NO') . " -> $path2\n";
}
