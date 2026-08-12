<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Tarif;
use App\Models\Rute;
use App\Models\Diskon;
use Illuminate\Http\Request;

class TarifController extends Controller
{
    public function index()
    {
        $tarifs = Tarif::latest()->paginate(10);
        $rutes = Rute::all();
        $diskons = Diskon::where('status', 'aktif')->get();
        $hasil = null;
        
        return view('public.tarif.index', compact('tarifs', 'rutes', 'diskons', 'hasil'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'id_rute' => 'required|exists:rutes,id_rute',
            'id_tarif' => 'required|exists:tarif_layanan,id_tarif',
            'id_diskon' => 'nullable|exists:diskons,id_diskon',
        ]);

        $rute = Rute::findOrFail($request->id_rute);
        $tarif = Tarif::findOrFail($request->id_tarif);
        $diskon = $request->id_diskon ? Diskon::findOrFail($request->id_diskon) : null;

        // Hitung total biaya
        $total = $rute->jarak_km * $tarif->tarif_per_km;

        // Cek minimal tarif
        if ($total < $tarif->minimal_tarif) {
            $total = $tarif->minimal_tarif;
        }

        // Hitung diskon
        $nominalDiskon = 0;
        $totalAkhir = $total;
        
        if ($diskon && $diskon->isActive()) {
            if ($diskon->tipe_diskon === 'persen') {
                $nominalDiskon = ($total * $diskon->diskon_persen) / 100;
            } else {
                $nominalDiskon = $diskon->diskon_nominal;
            }
            $totalAkhir = $total - $nominalDiskon;
        }

        return view('public.tarif.result', compact('rute', 'tarif', 'total', 'diskon', 'nominalDiskon', 'totalAkhir'));
    }
}