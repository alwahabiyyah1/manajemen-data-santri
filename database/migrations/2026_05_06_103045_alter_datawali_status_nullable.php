<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Ubah kolom status di data_wali menjadi nullable string.
     * Sebelumnya enum NOT NULL, menyebabkan error saat sync dari data ayah/ibu.
     */
    public function up(): void
    {
        // Ubah enum menjadi varchar nullable agar lebih fleksibel
        DB::statement("ALTER TABLE `data_wali` MODIFY `status` VARCHAR(50) NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `data_wali` MODIFY `status` ENUM('Paman/Bibi','Kakek/Nenek','Kakak Kandung','Saudara','Pesantren/Lembaga','Lainnya') NOT NULL");
    }
};
