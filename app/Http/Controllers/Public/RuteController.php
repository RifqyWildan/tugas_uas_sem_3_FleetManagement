<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Rute;
use Illuminate\Http\Request;

class RuteController extends Controller
{
    public function index()
    {
        $rutes = Rute::latest()->paginate(10);
        return view('public.rute.index', compact('rutes'));
    }
}