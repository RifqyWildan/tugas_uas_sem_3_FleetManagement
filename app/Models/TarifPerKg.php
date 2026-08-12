<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarifPerKg extends Model
{
    use HasFactory;

    protected $table = 'tarif_per_kgs';
    protected $primaryKey = 'id_tarif_kg';

    protected $fillable = [
        'nama_tarif',
        'harga_per_kg',
        'tipe_barang',
        'deskripsi',
        'status',
    ];

    protected $casts = [
        'harga_per_kg' => 'decimal:2',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'id_tarif_kg';
    }
}
