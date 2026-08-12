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
        Schema::create('tarif_per_kgs', function (Blueprint $table) {
            $table->id('id_tarif_kg');
            $table->string('nama_tarif')->comment('Nama tarif per kg');
            $table->decimal('harga_per_kg', 15, 2)->comment('Harga per kilogram');
            $table->string('tipe_barang')->nullable()->comment('Tipe/kategori barang (misal: Elektronik, Fragile, etc)');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarif_per_kgs');
    }
};
