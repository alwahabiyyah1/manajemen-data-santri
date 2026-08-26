<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('datasantri', function (Blueprint $table) {
            $table->string('foto_3x4')->nullable()->after('kebutuhan_disabilitas');
            $table->string('foto_kk')->nullable()->after('foto_3x4');
        });
    }

    public function down(): void
    {
        Schema::table('datasantri', function (Blueprint $table) {
            $table->dropColumn(['foto_3x4', 'foto_kk']);
        });
    }
};
