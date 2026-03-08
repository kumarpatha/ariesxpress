<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consignment;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total'       => Consignment::count(),
            'today'       => Consignment::whereDate('booking_date', today())->count(),
            'in_transit'  => Consignment::byStatus('in_transit')->count(),
            'delivered'   => Consignment::byStatus('delivered')->count(),
            'pod_updated' => Consignment::byStatus('pod_updated')->count(),
        ];

        $statusCounts = Consignment::selectRaw('delivery_status, count(*) as count')
            ->groupBy('delivery_status')
            ->pluck('count', 'delivery_status')
            ->toArray();

        $recentConsignments = Consignment::with('createdBy')
            ->latest()
            ->take(10)
            ->get();

        $allStatuses = Consignment::getStatuses();

        return view('admin.dashboard', compact('stats', 'statusCounts', 'recentConsignments', 'allStatuses'));
    }
}
