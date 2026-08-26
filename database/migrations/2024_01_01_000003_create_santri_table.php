<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('santri', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->primary();
            $table->integer('id_wali')->nullable()->index();
            $table->enum('status_data', ['aktif', 'tidak aktif', 'lulus', 'keluar'])->default('aktif');
            $table->timestamp('tanggal_input')->useCurrent();
            $table->timestamp('tanggal_update')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('santri');
    }
};
