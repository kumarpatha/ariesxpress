<?php

namespace App\Http\Controllers;

use App\Models\Consignment;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        return view('tracking.index');
    }

    public function track(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string',
        ]);

        $trackingNumber = strtoupper(trim($request->tracking_number));

        $consignment = Consignment::where('consignment_note_number', $trackingNumber)
                                  ->orWhere('tracking_number', $trackingNumber)
                                  ->with(['statusLogs' => function ($q) {
                                      $q->orderBy('created_at', 'asc');
                                  }])
                                  ->first();

        if (! $consignment) {
            return back()
                ->withInput()
                ->withErrors(['tracking_number' => 'No shipment found with this consignment number. Please check and try again.']);
        }

        return view('tracking.result', compact('consignment'));
    }
}
