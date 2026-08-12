<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    use HasFactory;

    protected $table = 'gudangs';
    protected $primaryKey = 'id_gudang';

    protected $fillable = [
        'nama_gudang',
        'alamat',
        'kapasitas',
        'stok',
        'status',
        'catatan',
        'tarif_per_kg',
        'diskon_persen',
    ];

    protected $casts = [
        'kapasitas' => 'decimal:2',
        'stok' => 'integer',
        'tarif_per_kg' => 'decimal:2',
        'diskon_persen' => 'decimal:2',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'id_gudang';
    }

    /**
     * Hitung harga total barang berdasarkan berat dan tarif
     * @param float $berat_kg Berat barang dalam kg
     * @return array Array berisi harga sebelum diskon, diskon, dan total harga
     */
    public function hitungHarga($berat_kg)
    {
        $harga_sebelum_diskon = $berat_kg * $this->tarif_per_kg;
        $nominal_diskon = ($harga_sebelum_diskon * $this->diskon_persen) / 100;
        $harga_akhir = $harga_sebelum_diskon - $nominal_diskon;

        return [
            'berat_kg' => $berat_kg,
            'tarif_per_kg' => $this->tarif_per_kg,
            'harga_sebelum_diskon' => $harga_sebelum_diskon,
            'diskon_persen' => $this->diskon_persen,
            'nominal_diskon' => $nominal_diskon,
            'harga_akhir' => $harga_akhir,
        ];
    }

    /**
     * Relasi ke StokGudang (one-to-one atau one-to-many)
     */
    public function stokGudang()
    {
        return $this->hasMany(StokGudang::class, 'gudang_id', 'id_gudang');
    }
}