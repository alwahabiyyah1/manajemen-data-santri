<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Relasi Santri ke WaliSantri
        Schema::table('santri', function (Blueprint $table) {
            $table->foreign('id_wali')->references('id_wali')->on('wali_santri')->onDelete('set null');
        });

        // 2. Relasi DataSantri ke Santri
        Schema::table('datasantri', function (Blueprint $table) {
            $table->foreign('id_santri')->references('id')->on('santri')->onDelete('cascade');
        });

        // 3. Relasi DataAyah ke Santri
        Schema::table('dataayah', function (Blueprint $table) {
            $table->foreign('id_santri')->references('id')->on('santri')->onDelete('cascade');
        });

        // 4. Relasi DataIbu ke Santri
        Schema::table('dataibu', function (Blueprint $table) {
            $table->foreign('id_santri')->references('id')->on('santri')->onDelete('cascade');
        });

        // 5. Relasi AlamatSantri ke Santri
        Schema::table('alamatsantri', function (Blueprint $table) {
            $table->foreign('id_santri')->references('id')->on('santri')->onDelete('cascade');
        });

        // 6. Relasi AlamatAyah ke DataAyah
        Schema::table('alamatayah', function (Blueprint $table) {
            $table->foreign('id_ayah')->references('id_ayah')->on('dataayah')->onDelete('cascade');
        });

        // 7. Relasi AlamatIbu ke DataIbu
        Schema::table('alamatibu', function (Blueprint $table) {
            $table->foreign('id_ibu')->references('id_ibu')->on('dataibu')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alamatibu', function (Blueprint $table) {
            $table->dropForeign(['id_ibu']);
        });

        Schema::table('alamatayah', function (Blueprint $table) {
            $table->dropForeign(['id_ayah']);
        });

        Schema::table('alamatsantri', function (Blueprint $table) {
            $table->dropForeign(['id_santri']);
        });

        Schema::table('dataibu', function (Blueprint $table) {
            $table->dropForeign(['id_santri']);
        });

        Schema::table('dataayah', function (Blueprint $table) {
            $table->dropForeign(['id_santri']);
        });

        Schema::table('datasantri', function (Blueprint $table) {
            $table->dropForeign(['id_santri']);
        });

        Schema::table('santri', function (Blueprint $table) {
            $table->dropForeign(['id_wali']);
        });
    }
};
