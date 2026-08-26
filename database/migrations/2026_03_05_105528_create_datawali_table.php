<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_wali', function (Blueprint $table) {
            $table->integer('id_wali')->autoIncrement()->primary();
            $table->integer('id_santri');
            $table->foreign('id_santri')->references('id')->on('santri')->onDelete('cascade');
            
            $table->string('nama_lengkap', 100);
            $table->enum('status', ['Paman/Bibi', 'Kakek/Nenek', 'Kakak Kandung', 'Saudara', 'Pesantren/Lembaga', 'Lainnya']);
            $table->enum('kewarganegaraan', ['WNI', 'WNA']);
            $table->string('nik', 16)->nullable();
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('pendidikan_terakhir', 20)->nullable();
            $table->string('pekerjaan_utama', 50)->nullable();
            $table->string('penghasilan_perbulan', 50)->nullable();
            $table->string('no_hp', 15)->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_wali');
    }
};
