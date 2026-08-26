<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Ubah kolom penghasilan_perbulan dari decimal ke string
     * karena menyimpan range teks seperti '10.000.001 - 20.000.000'
     */
    public function up(): void
    {
        Schema::table('dataayah', function (Blueprint $table) {
            $table->string('penghasilan_perbulan', 50)->nullable()->change();
        });

        Schema::table('dataibu', function (Blueprint $table) {
            $table->string('penghasilan_perbulan', 50)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dataayah', function (Blueprint $table) {
            $table->decimal('penghasilan_perbulan', 15, 2)->nullable()->change();
        });

        Schema::table('dataibu', function (Blueprint $table) {
            $table->decimal('penghasilan_perbulan', 15, 2)->nullable()->change();
        });
    }
};
