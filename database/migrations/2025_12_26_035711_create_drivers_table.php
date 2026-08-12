<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id('id_driver');
            $table->string('nama');
            $table->string('no_ktp');
            $table->string('no_sim');
            $table->enum('tipe_sim', ['A', 'B1', 'B2', 'C']); // atau sesuaikan dengan tipe SIM yang ada
            $table->string('telepon');
            $table->text('alamat');
            $table->enum('status_aktif', ['aktif', 'tidak_aktif', 'cuti'])->default('aktif');
            $table->date('tanggal_gabung');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};