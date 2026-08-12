<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rute extends Model
{
    use HasFactory;

    protected $table = 'rutes';
    protected $primaryKey = 'id_rute';

    protected $fillable = [
        'nama_rute',
        'asal',
        'tujuan',
        'jarak_km',
        'estimasi_waktu',
        'tarif',
        'catatan',
    ];

    protected $casts = [
        'jarak_km' => 'decimal:2',
        'estimasi_waktu' => 'integer',
        'tarif' => 'decimal:2',
    ];

    // Relasi: Rute memiliki banyak pengiriman
    public function trackings()
    {
        return $this->hasMany(Tracking::class, 'id_rute', 'id_rute');
    }
}