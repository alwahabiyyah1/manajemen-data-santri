<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dataayah', function (Blueprint $table) {
            $table->integer('id_ayah')->autoIncrement()->primary();
            $table->integer('id_santri')->index();
            $table->string('nama_lengkap');
            $table->string('status')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->string('nik')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('pekerjaan_utama')->nullable();
            $table->decimal('penghasilan_perbulan', 15, 2)->nullable();
            $table->string('no_hp')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dataayah');
    }
};
