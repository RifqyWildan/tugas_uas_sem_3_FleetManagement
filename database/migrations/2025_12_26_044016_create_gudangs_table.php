<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gudangs', function (Blueprint $table) {
            $table->id('id_gudang');
            $table->string('nama_gudang');
            $table->text('alamat');
            $table->decimal('kapasitas', 10, 2); // kapasitas dalam ton atau m³
            $table->enum('status', ['aktif', 'tidak_aktif', 'penuh', 'maintenance'])->default('aktif');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gudangs');
    }
};