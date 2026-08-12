<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'service_kendaraan';
    protected $primaryKey = 'id_service';

    protected $fillable = [
        'id_armada',
        'tanggal_service',
        'jenis_service',
        'deskripsi',
        'catatan',
        'biaya',
    ];

    protected $casts = [
        'tanggal_service' => 'date',
        'biaya' => 'decimal:2',
    ];

    // Relasi: Service belongs to Armada
    public function armada()
    {
        return $this->belongsTo(Armada::class, 'id_armada', 'id_armada');
    }
}