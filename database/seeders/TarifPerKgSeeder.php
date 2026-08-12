<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TarifPerKg;

class TarifPerKgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tarifPerKgs = [
            [
                'nama_tarif' => 'Tarif Standard',
                'harga_per_kg' => 10000,
                'tipe_barang' => 'General/Umum',
                'deskripsi' => 'Tarif standar untuk barang umum tanpa kebutuhan khusus',
                'status' => 'aktif',
            ],
            [
                'nama_tarif' => 'Tarif Elektronik',
                'harga_per_kg' => 15000,
                'tipe_barang' => 'Elektronik',
                'deskripsi' => 'Tarif khusus untuk barang elektronik dengan asuransi ekstra',
                'status' => 'aktif',
            ],
            [
                'nama_tarif' => 'Tarif Fragile',
                'harga_per_kg' => 20000,
                'tipe_barang' => 'Fragile/Mudah Pecah',
                'deskripsi' => 'Tarif untuk barang yang mudah pecah atau rusak (kaca, keramik, dll)',
                'status' => 'aktif',
            ],
            [
                'nama_tarif' => 'Tarif Makanan',
                'harga_per_kg' => 12000,
                'tipe_barang' => 'Makanan/Minuman',
                'deskripsi' => 'Tarif untuk pengiriman makanan dan minuman dengan jaga kesegaran',
                'status' => 'aktif',
            ],
            [
                'nama_tarif' => 'Tarif Hazmat',
                'harga_per_kg' => 25000,
                'tipe_barang' => 'Bahan Berbahaya',
                'deskripsi' => 'Tarif untuk barang berbahaya yang memerlukan penanganan khusus',
                'status' => 'aktif',
            ],
            [
                'nama_tarif' => 'Tarif Dokumen',
                'harga_per_kg' => 5000,
                'tipe_barang' => 'Dokumen/Surat',
                'deskripsi' => 'Tarif murah untuk pengiriman dokumen, surat, dan berkas penting',
                'status' => 'aktif',
            ],
            [
                'nama_tarif' => 'Tarif Premium',
                'harga_per_kg' => 30000,
                'tipe_barang' => 'Barang Bernilai Tinggi',
                'deskripsi' => 'Tarif premium untuk barang mahal dengan asuransi penuh dan tracking real-time',
                'status' => 'aktif',
            ],
        ];

        foreach ($tarifPerKgs as $tarif) {
            TarifPerKg::create($tarif);
        }
    }
}
