<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$columns = DB::select('DESCRIBE wali_santri');
foreach($columns as $col) {
    echo $col->Field . " | " . $col->Type . " | Null: " . $col->Null . "\n";
}
