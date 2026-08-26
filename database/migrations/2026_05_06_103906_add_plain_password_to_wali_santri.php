<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom plain_password agar admin bisa melihat/menginformasikan
     * password akun wali ke orang tua santri.
     */
    public function up(): void
    {
        Schema::table('wali_santri', function (Blueprint $table) {
            $table->string('plain_password', 100)->nullable()->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('wali_santri', function (Blueprint $table) {
            $table->dropColumn('plain_password');
        });
    }
};
