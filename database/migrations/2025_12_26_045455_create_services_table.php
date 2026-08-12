<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_kendaraan', function (Blueprint $table) {
            $table->id('id_service');
            $table->foreignId('id_armada')->constrained('armadas', 'id_armada')->onDelete('cascade');
            $table->date('tanggal_service');
            $table->string('jenis_service'); // Service Rutin, Perbaikan, Ganti Oli, dll
            $table->text('catatan')->nullable();
            $table->decimal('biaya', 15, 2); // biaya service
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_kendaraan');
    }
};