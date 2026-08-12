<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Armada extends Model
{
    use HasFactory;

    protected $table = 'armadas';
    protected $primaryKey = 'id_armada';

    protected $fillable = [
        'nomor_polisi',
        'jenis_kendaraan',
        'merk',
        'kapasitas_muatan',
        'tahun_pembuatan',
        'status',
        'foto',
        'catatan',
    ];

    protected $casts = [
        'kapasitas_muatan' => 'decimal:2',
        'tahun_pembuatan' => 'integer',
    ];

    // Relasi: Armada memiliki banyak pengiriman
    public function trackings()
    {
        return $this->hasMany(Tracking::class, 'id_armada', 'id_armada');
    }

    // Relasi: Armada memiliki banyak riwayat service
    public function services()
    {
        return $this->hasMany(Service::class, 'id_armada', 'id_armada');
    }

    // Accessor: full foto URL or placeholder
    public function getFotoUrlAttribute()
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            // Prefer public storage symlink if available
            $publicPath = public_path('storage/' . $this->foto);
            if (file_exists($publicPath)) {
                return asset('storage/' . $this->foto);
            }

            // If symlink doesn't exist, serve via route that reads storage file
            return route('public.storage.file', ['path' => base64_encode($this->foto)]);
        }

        // fallback placeholder
        return asset('images/no-image.svg');
    }
}