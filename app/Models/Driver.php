<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Driver extends Model
{
    use HasFactory;

    protected $table = 'drivers';
    protected $primaryKey = 'id_driver';

    protected $fillable = [
        'nama',
        'no_ktp',
        'no_sim',
        'tipe_sim',
        'telepon',
        'alamat',
        'status_aktif',
        'tanggal_gabung',
        'foto',
    ];

    protected $casts = [
        'tanggal_gabung' => 'date',
    ];

    // Relasi: Driver memiliki banyak pengiriman
    public function trackings()
    {
        return $this->hasMany(Tracking::class, 'id_driver', 'id_driver');
    }

    // Accessor: full foto URL or placeholder
    public function getFotoUrlAttribute()
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            $publicPath = public_path('storage/' . $this->foto);
            if (file_exists($publicPath)) {
                return asset('storage/' . $this->foto);
            }

            return route('public.storage.file', ['path' => base64_encode($this->foto)]);
        }

        return asset('images/no-image.svg');
    }
}