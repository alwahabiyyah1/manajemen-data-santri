<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wali_santri', function (Blueprint $table) {
            $table->integer('id_wali')->autoIncrement()->primary();
            $table->string('nama_wali');
            $table->string('no_hp');
            $table->text('alamat')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('username')->unique();
            $table->string('password', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wali_santri');
    }
};
