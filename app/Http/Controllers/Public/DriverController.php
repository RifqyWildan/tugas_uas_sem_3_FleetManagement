<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::where('status_aktif', 'aktif')->latest()->paginate(12);
        return view('public.driver.index', compact('drivers'));
    }
}