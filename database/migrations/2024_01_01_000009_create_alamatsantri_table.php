<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alamatsantri', function (Blueprint $table) {
            $table->integer('id_alamatsantri')->autoIncrement()->primary();
            $table->integer('id_santri')->index();
            $table->string('status_mukim')->nullable();
            $table->string('status_tempat_tinggal')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('desa')->nullable();
            $table->string('rw')->nullable();
            $table->string('rt')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('jarak_ke_lembaga')->nullable();
            $table->string('transportasi')->nullable();
            $table->string('waktu_tempuh')->nullable();
            $table->string('koordinat')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alamatsantri');
    }
};
