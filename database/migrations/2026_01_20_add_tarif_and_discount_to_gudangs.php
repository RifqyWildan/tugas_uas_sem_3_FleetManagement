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
        Schema::table('gudangs', function (Blueprint $table) {
            $table->decimal('tarif_per_kg', 15, 2)->default(0)->after('kapasitas')->comment('Tarif per kg barang');
            $table->decimal('diskon_persen', 5, 2)->default(0)->after('tarif_per_kg')->comment('Diskon dalam persen (%)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gudangs', function (Blueprint $table) {
            $table->dropColumn(['tarif_per_kg', 'diskon_persen']);
        });
    }
};
