<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('datasantri', function (Blueprint $table) {
            $table->integer('id_santri')->primary();
            $table->string('nama_lengkap');
            $table->string('no_kk')->nullable();
            $table->string('nik')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('jumlah_saudara')->nullable();
            $table->string('anak_ke')->nullable();
            $table->string('cita_cita')->nullable();
            $table->string('agama')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->string('hobi')->nullable();
            $table->string('pembiaya_sekolah')->nullable();
            $table->string('kebutuhan_khusus')->nullable();
            $table->string('kebutuhan_disabilitas')->nullable();
            $table->string('nama_kapala_keluarga')->nullable();
            $table->year('tahun_masuk')->nullable();
            $table->year('tahun_keluar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('datasantri');
    }
};
