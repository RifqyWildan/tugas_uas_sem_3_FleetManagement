<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Armada;
use App\Models\Driver;
use App\Models\Tarif;

class HomeController extends Controller
{
    public function index()
    {
        $armadas = Armada::latest()->take(3)->get();
        $drivers = Driver::latest()->take(3)->get();
        $tarifs = Tarif::latest()->take(3)->get();

        $stats = [
            'armada' => Armada::count(),
            'rute' => \App\Models\Rute::count(),
            'driver' => Driver::count(),
            'gudang' => \App\Models\Gudang::count(),
        ];

        return view('public.wellcome', compact('armadas', 'drivers', 'tarifs', 'stats'));
    }
}
