<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Tracking;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index(Request $request)
    {
        $tracking = null;
        if ($request->has('resi')) {
            $tracking = Tracking::with(['armada','driver','rute'])
                ->where('no_resi', $request->resi)
                ->first();

            if (! $tracking) {
                session()->flash('error', 'Nomor resi tidak ditemukan!');
            }
        }

        // Get all active trackings
        $allTrackings = Tracking::with(['armada','driver','rute'])
            ->whereIn('status_pengiriman', ['dikirim', 'dalam_perjalanan'])
            ->latest()
            ->get();

        return view('public.tracking.index', compact('tracking', 'allTrackings'));
    }

    public function cek(Request $request)
    {
        $request->validate([
            'no_resi' => 'required',
        ]);

        // Redirect to GET index with resi param; index will perform the lookup and show result or error
        return redirect()->route('public.tracking.index', ['resi' => $request->no_resi]);
    }
}