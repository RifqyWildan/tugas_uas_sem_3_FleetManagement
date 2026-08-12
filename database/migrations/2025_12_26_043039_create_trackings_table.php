<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->id('id_pengiriman');
            $table->foreignId('id_armada')->constrained('armadas', 'id_armada')->onDelete('restrict');
            $table->foreignId('id_driver')->nullable()->constrained('drivers', 'id_driver')->onDelete('restrict');
            $table->foreignId('id_rute')->nullable()->constrained('rutes', 'id_rute')->onDelete('restrict');
            $table->string('no_resi');
            $table->enum('status_pengiriman', ['pending', 'dikirim', 'dalam_perjalanan', 'sampai', 'selesai', 'batal'])->default('pending');
            $table->date('tanggal_kirim');
            $table->date('tanggal_sampai')->nullable();
            $table->string('lokasi_terakhir')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengiriman');
    }
};