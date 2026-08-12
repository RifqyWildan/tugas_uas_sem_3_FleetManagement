<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tarif_layanan', function (Blueprint $table) {
            $table->id('id_tarif');
            $table->string('nama_layanan'); // Express, Regular, Ekonomi, dll
            $table->decimal('tarif_per_km', 10, 2); // tarif per kilometer
            $table->decimal('minimal_tarif', 15, 2); // minimal tarif yang harus dibayar
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tarif_layanan');
    }
};