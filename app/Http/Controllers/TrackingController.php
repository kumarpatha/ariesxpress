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
            'phone_number'    => 'required|string',
        ]);

        $consignment = Consignment::where('tracking_number', strtoupper(trim($request->tracking_number)))
                                  ->where('phone_number', trim($request->phone_number))
                                  ->with(['statusLogs' => function ($q) {
                                      $q->orderBy('created_at', 'asc');
                                  }])
                                  ->first();

        if (! $consignment) {
            return back()
                ->withInput()
                ->withErrors(['tracking_number' => 'No shipment found with this tracking number and phone number combination. Please check and try again.']);
        }

        return view('tracking.result', compact('consignment'));
    }
}
