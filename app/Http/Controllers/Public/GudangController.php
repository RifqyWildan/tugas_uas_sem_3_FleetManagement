<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Gudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function index()
    {
        $gudangs = Gudang::where('status', 'aktif')->latest()->paginate(8);
        return view('public.gudang.index', compact('gudangs'));
    }
}