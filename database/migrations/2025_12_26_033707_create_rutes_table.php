<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rutes', function (Blueprint $table) {
            $table->id('id_rute');
            $table->string('nama_rute');
            $table->string('asal');
            $table->string('tujuan');
            $table->decimal('jarak_km', 10, 2); // decimal untuk support desimal
            $table->string('estimasi_waktu'); // estimasi waktu (teks, mis. '2 hari')
            $table->decimal('tarif', 15, 2); // tarif dasar rute
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rutes');
    }
};