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
        Schema::create('diskons', function (Blueprint $table) {
            $table->id('id_diskon');
            $table->string('nama_diskon')->comment('Nama diskon');
            $table->decimal('diskon_persen', 5, 2)->comment('Diskon dalam persen');
            $table->decimal('diskon_nominal', 15, 2)->nullable()->comment('Diskon dalam nominal rupiah (opsional)');
            $table->date('tanggal_mulai')->nullable()->comment('Tanggal berlaku diskon');
            $table->date('tanggal_selesai')->nullable()->comment('Tanggal berakhir diskon');
            $table->enum('tipe_diskon', ['persen', 'nominal', 'otomatis'])->default('persen')->comment('Tipe diskon: persen, nominal, atau otomatis');
            $table->text('keterangan')->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diskons');
    }
};
