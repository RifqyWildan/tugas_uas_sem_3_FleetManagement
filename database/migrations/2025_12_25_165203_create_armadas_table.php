<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('armadas', function (Blueprint $table) {
            $table->id('id_armada');
            $table->string('nomor_polisi');
            $table->string('jenis_kendaraan');
            $table->string('merk');
            $table->decimal('kapasitas_muatan', 10, 2); // dalam ton atau kg
            $table->year('tahun_pembuatan');
            $table->enum('status', ['aktif', 'tidak_aktif', 'maintenance'])->default('aktif');
            $table->string('foto')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps(); // ini akan create created_at dan updated_at
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('armadas');
    }
};