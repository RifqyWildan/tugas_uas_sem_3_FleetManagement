<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    use HasFactory;

    protected $table = 'diskons';
    protected $primaryKey = 'id_diskon';

    protected $fillable = [
        'nama_diskon',
        'diskon_persen',
        'diskon_nominal',
        'tanggal_mulai',
        'tanggal_selesai',
        'tipe_diskon',
        'keterangan',
        'status',
    ];

    protected $casts = [
        'diskon_persen' => 'decimal:2',
        'diskon_nominal' => 'decimal:2',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'id_diskon';
    }

    /**
     * Check if diskon is currently active (berdasarkan tanggal)
     */
    public function isActive()
    {
        $now = now()->toDateString();
        
        // Jika tidak ada tanggal, anggap selalu aktif
        if (!$this->tanggal_mulai && !$this->tanggal_selesai) {
            return $this->status === 'aktif';
        }

        $mulai = $this->tanggal_mulai ? $this->tanggal_mulai->toDateString() : null;
        $selesai = $this->tanggal_selesai ? $this->tanggal_selesai->toDateString() : null;

        $withinRange = true;
        if ($mulai) $withinRange = $withinRange && $now >= $mulai;
        if ($selesai) $withinRange = $withinRange && $now <= $selesai;

        return $this->status === 'aktif' && $withinRange;
    }
}
