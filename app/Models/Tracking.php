<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;

    protected $table = 'pengiriman';
    protected $primaryKey = 'id_pengiriman';

    protected $fillable = [
        'id_armada',
        'id_driver',
        'id_rute',
        'no_resi',
        'status_pengiriman',
        'tanggal_kirim',
        'tanggal_sampai',
        'lokasi_terakhir',
        'catatan',
    ];

    protected $casts = [
        'tanggal_kirim' => 'date',
        'tanggal_sampai' => 'date',
    ];

    // Relasi: Tracking belongs to Armada
    public function armada()
    {
        return $this->belongsTo(Armada::class, 'id_armada', 'id_armada');
    }

    // Relasi: Tracking belongs to Driver
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'id_driver', 'id_driver');
    }

    // Relasi: Tracking belongs to Rute
    public function rute()
    {
        return $this->belongsTo(Rute::class, 'id_rute', 'id_rute');
    }
}