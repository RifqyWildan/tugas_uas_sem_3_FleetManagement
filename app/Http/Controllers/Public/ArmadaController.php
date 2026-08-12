<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Armada;
use Illuminate\Http\Request;

class ArmadaController extends Controller
{
    public function index()
    {
        // Ubah dari get() ke paginate()
        $armadas = Armada::where('status', 'aktif')->latest()->paginate(9);
        return view('public.armada.index', compact('armadas'));
    }
}