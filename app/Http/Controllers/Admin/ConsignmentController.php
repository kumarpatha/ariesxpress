<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Consignment;
use App\Models\ConsignmentStatusLog;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConsignmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Consignment::with('createdBy')->latest();

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('booking_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('booking_date', '<=', $request->date_to);
        }

        $consignments = $query->paginate(15)->withQueryString();
        $allStatuses  = Consignment::getStatuses();
        $serviceModes = Consignment::getServiceModes();

        return view('admin.consignments.index', compact('consignments', 'allStatuses', 'serviceModes'));
    }

    public function create()
    {
        $branches     = Branch::active()->orderBy('name')->get();
        $allStatuses  = Consignment::getStatuses();
        $serviceModes = Consignment::getServiceModes();

        return view('admin.consignments.create', compact('branches', 'allStatuses', 'serviceModes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'consignment_note_number' => 'required|string|max:30|unique:consignments,consignment_note_number',
            'booking_date'          => 'required|date_format:d/m/Y',
            'consigner_name'        => 'required|string|max:191',
            'consigner_address'     => 'required|string',
            'consigner_gst_number'  => 'nullable|string|max:30',
            'consignee_name'        => 'required|string|max:191',
            'consignee_address'     => 'required|string',
            'consignee_gst_number'  => 'nullable|string|max:30',
            'phone_number'          => 'required|string|max:20',
            'item_description'      => 'required|string',
            'origin'                => 'required|string|max:191',
            'destination'           => 'required|string|max:191',
            'origin_branch_id'      => 'nullable|exists:branches,id',
            'destination_branch_id' => 'nullable|exists:branches,id',
            'no_of_boxes'           => 'required|integer|min:1',
            'actual_weight'         => 'required|numeric|min:0',
            'chargeable_weight'     => 'required|numeric|min:0',
            'service_mode'          => 'required|in:road,air,rail,express',
            'total_amount'          => 'required|numeric|min:0',
            'grand_total'           => 'required|numeric|min:0',
            'final_remark'          => 'nullable|string',
        ]);

        $validated['created_by'] = Auth::guard('admin')->id();
        $validated['consignment_note_number'] = strtoupper(trim($validated['consignment_note_number']));
        $validated['booking_date'] = Carbon::createFromFormat('d/m/Y', $validated['booking_date'])->format('Y-m-d');

        $consignment = null;

        DB::transaction(function () use ($validated, &$consignment) {
            $consignment = Consignment::create($validated);

            ConsignmentStatusLog::create([
                'consignment_id' => $consignment->id,
                'status'         => 'booking',
                'comment'        => 'Consignment registered.',
                'location'       => $validated['origin'] ?? null,
                'updated_by'     => Auth::guard('admin')->id(),
            ]);
        });

        return redirect()->route('admin.consignments.show', $consignment->id)
                         ->with('success', 'Consignment created successfully! CN: ' . $consignment->consignment_note_number);
    }

    public function show($id)
    {
        $consignment = Consignment::with([
            'statusLogs.admin',
            'createdBy',
            'originBranch',
            'destinationBranch',
        ])->findOrFail($id);

        $allStatuses  = Consignment::getStatuses();
        $serviceModes = Consignment::getServiceModes();

        return view('admin.consignments.show', compact('consignment', 'allStatuses', 'serviceModes'));
    }

    public function edit($id)
    {
        $consignment  = Consignment::findOrFail($id);
        $branches     = Branch::active()->orderBy('name')->get();
        $serviceModes = Consignment::getServiceModes();

        return view('admin.consignments.edit', compact('consignment', 'branches', 'serviceModes'));
    }

    public function update(Request $request, $id)
    {
        $consignment = Consignment::findOrFail($id);

        $validated = $request->validate([
            'booking_date'          => 'required|date_format:d/m/Y',
            'consigner_name'        => 'required|string|max:191',
            'consigner_address'     => 'required|string',
            'consigner_gst_number'  => 'nullable|string|max:30',
            'consignee_name'        => 'required|string|max:191',
            'consignee_address'     => 'required|string',
            'consignee_gst_number'  => 'nullable|string|max:30',
            'phone_number'          => 'required|string|max:20',
            'item_description'      => 'required|string',
            'origin'                => 'required|string|max:191',
            'destination'           => 'required|string|max:191',
            'origin_branch_id'      => 'nullable|exists:branches,id',
            'destination_branch_id' => 'nullable|exists:branches,id',
            'no_of_boxes'           => 'required|integer|min:1',
            'actual_weight'         => 'required|numeric|min:0',
            'chargeable_weight'     => 'required|numeric|min:0',
            'service_mode'          => 'required|in:road,air,rail,express',
            'total_amount'          => 'required|numeric|min:0',
            'grand_total'           => 'required|numeric|min:0',
            'final_remark'          => 'nullable|string',
        ]);

        $validated['booking_date'] = Carbon::createFromFormat('d/m/Y', $validated['booking_date'])->format('Y-m-d');

        $consignment->update($validated);

        return redirect()->route('admin.consignments.show', $consignment->id)
                         ->with('success', 'Consignment updated successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $consignment = Consignment::findOrFail($id);

        $validated = $request->validate([
            'status'   => 'required|in:booking,dispatched,in_transit,arrived_at_destination,out_for_delivery,delivered,pod_updated',
            'comment'  => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:191',
        ]);

        DB::transaction(function () use ($consignment, $validated) {
            $consignment->update(['delivery_status' => $validated['status']]);

            ConsignmentStatusLog::create([
                'consignment_id' => $consignment->id,
                'status'         => $validated['status'],
                'comment'        => $validated['comment'] ?? null,
                'location'       => $validated['location'] ?? null,
                'updated_by'     => Auth::guard('admin')->id(),
            ]);
        });

        $statusLabels = Consignment::getStatuses();

        return redirect()->route('admin.consignments.show', $consignment->id)
                         ->with('success', 'Status updated to "' . $statusLabels[$validated['status']] . '".');
    }
}
