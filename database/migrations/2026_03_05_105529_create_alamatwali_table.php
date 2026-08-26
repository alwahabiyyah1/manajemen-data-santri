<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alamat_wali', function (Blueprint $table) {
            $table->integer('id_alamat')->autoIncrement()->primary();
            $table->integer('id_wali');
            $table->foreign('id_wali')->references('id_wali')->on('data_wali')->onDelete('cascade');
            
            $table->string('status_kepemilikan', 50)->nullable();
            $table->string('provinsi', 50)->nullable();
            $table->string('kabupaten', 50)->nullable();
            $table->string('kecamatan', 50)->nullable();
            $table->string('desa', 50)->nullable();
            $table->string('rw', 5)->nullable();
            $table->string('rt', 5)->nullable();
            $table->text('alamat')->nullable();
            $table->string('kode_pos', 10)->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alamat_wali');
    }
};
