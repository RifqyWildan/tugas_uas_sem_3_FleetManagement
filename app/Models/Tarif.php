<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    use HasFactory;

    protected $table = 'tarif_layanan';
    protected $primaryKey = 'id_tarif';

    protected $fillable = [
        'nama_layanan',
        'tarif_per_km',
        'minimal_tarif',
        'catatan',
    ];

    protected $casts = [
        'tarif_per_km' => 'decimal:2',
        'minimal_tarif' => 'decimal:2',
    ];
}