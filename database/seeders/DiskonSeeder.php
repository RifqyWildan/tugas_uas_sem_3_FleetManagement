<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Diskon;
use Carbon\Carbon;

class DiskonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $diskons = [
            [
                'nama_diskon' => 'Diskon Member Setia',
                'tipe_diskon' => 'persen',
                'diskon_persen' => 10,
                'diskon_nominal' => 0,
                'tanggal_mulai' => null,
                'tanggal_selesai' => null,
                'keterangan' => 'Diskon khusus untuk member setia tanpa batas waktu',
                'status' => 'aktif',
            ],
            [
                'nama_diskon' => 'Promo Flash Sale 50%',
                'tipe_diskon' => 'persen',
                'diskon_persen' => 50,
                'diskon_nominal' => 0,
                'tanggal_mulai' => Carbon::now()->toDateString(),
                'tanggal_selesai' => Carbon::now()->addDays(7)->toDateString(),
                'keterangan' => 'Flash sale terbatas 7 hari dengan diskon besar',
                'status' => 'aktif',
            ],
            [
                'nama_diskon' => 'Diskon Nominal Rp 25.000',
                'tipe_diskon' => 'nominal',
                'diskon_persen' => 0,
                'diskon_nominal' => 25000,
                'tanggal_mulai' => null,
                'tanggal_selesai' => null,
                'keterangan' => 'Potongan langsung Rp 25.000 untuk setiap pengiriman',
                'status' => 'aktif',
            ],
            [
                'nama_diskon' => 'Diskon Bulanan Januari',
                'tipe_diskon' => 'persen',
                'diskon_persen' => 15,
                'diskon_nominal' => 0,
                'tanggal_mulai' => Carbon::createFromDate(2026, 1, 1)->toDateString(),
                'tanggal_selesai' => Carbon::createFromDate(2026, 1, 31)->toDateString(),
                'keterangan' => 'Diskon spesial bulan Januari sebesar 15%',
                'status' => 'aktif',
            ],
            [
                'nama_diskon' => 'Diskon Referral',
                'tipe_diskon' => 'persen',
                'diskon_persen' => 20,
                'diskon_nominal' => 0,
                'tanggal_mulai' => null,
                'tanggal_selesai' => null,
                'keterangan' => 'Diskon untuk pelanggan yang mereferensikan teman',
                'status' => 'aktif',
            ],
            [
                'nama_diskon' => 'Early Bird Special',
                'tipe_diskon' => 'persen',
                'diskon_persen' => 12,
                'diskon_nominal' => 0,
                'tanggal_mulai' => Carbon::now()->toDateString(),
                'tanggal_selesai' => Carbon::now()->addDays(30)->toDateString(),
                'keterangan' => 'Promo awal tahun dengan diskon 12% untuk early bird',
                'status' => 'aktif',
            ],
            [
                'nama_diskon' => 'Diskon Tidak Aktif (Contoh)',
                'tipe_diskon' => 'persen',
                'diskon_persen' => 5,
                'diskon_nominal' => 0,
                'tanggal_mulai' => Carbon::now()->subDays(30)->toDateString(),
                'tanggal_selesai' => Carbon::now()->subDays(1)->toDateString(),
                'keterangan' => 'Contoh diskon yang sudah berakhir',
                'status' => 'tidak_aktif',
            ],
        ];

        foreach ($diskons as $diskon) {
            Diskon::create($diskon);
        }
    }
}
