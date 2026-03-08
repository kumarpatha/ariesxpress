@extends('admin.layouts.app')

@section('title', 'Consignment - ' . $consignment->consignment_note_number)
@section('page-title', 'Consignment Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.consignments.index') }}">Consignments</a></li>
    <li class="breadcrumb-item active">{{ $consignment->consignment_note_number }}</li>
@endsection

@section('content')
<div class="row">
    <!-- Left: Consignment Details -->
    <div class="col-md-8">

        <!-- CN Banner -->
        <div class="card card-primary card-outline">
            <div class="card-body py-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <div>
                        <small class="text-muted d-block">Consignment Note Number</small>
                        <h3 class="mb-0 font-weight-bold text-primary" id="cnNumber">
                            {{ $consignment->consignment_note_number }}
                        </h3>
                        <small class="text-muted d-block mt-1">Tracking Number</small>
                        <h5 class="mb-0 font-weight-bold text-secondary">
                            {{ $consignment->tracking_number }}
                            <button onclick="copyToClipboard('{{ $consignment->tracking_number }}')"
                                    class="btn btn-xs btn-outline-secondary ml-1">
                                <i class="fas fa-copy mr-1"></i>Copy
                            </button>
                        </h5>
                    </div>
                    <div class="text-right">
                        <span class="badge badge-{{ \App\Models\Consignment::getStatusBadgeClass($consignment->delivery_status) }} badge-lg p-2">
                            <i class="fas {{ \App\Models\Consignment::getStatusIconClass($consignment->delivery_status) }} mr-1"></i>
                            {{ $allStatuses[$consignment->delivery_status] ?? $consignment->delivery_status }}
                        </span>
                        <div class="mt-1">
                            <button onclick="copyToClipboard('{{ $consignment->consignment_note_number }}')"
                                    class="btn btn-xs btn-outline-secondary">
                                <i class="fas fa-copy mr-1"></i>Copy CN
                            </button>
                            <a href="{{ route('admin.consignments.edit', $consignment->id) }}" class="btn btn-xs btn-warning">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="row">
            <!-- Booking Info -->
            <div class="col-md-6">
                <div class="card card-outline card-info">
                    <div class="card-header py-2">
                        <h5 class="card-title mb-0"><i class="fas fa-info-circle mr-2 text-info"></i>Booking Info</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm mb-0">
                            <tr><th class="w-50">Booking Date</th><td>{{ $consignment->booking_date->format('d M Y') }}</td></tr>
                            <tr><th>Origin</th><td>{{ $consignment->origin }}</td></tr>
                            <tr><th>Destination</th><td>{{ $consignment->destination }}</td></tr>
                            <tr><th>Service Mode</th><td><span class="badge badge-secondary">{{ strtoupper($consignment->service_mode) }}</span></td></tr>
                            <tr><th>Phone</th><td>{{ $consignment->phone_number }}</td></tr>
                            @if($consignment->originBranch)
                            <tr><th>Origin Branch</th><td>{{ $consignment->originBranch->name }}</td></tr>
                            @endif
                            @if($consignment->destinationBranch)
                            <tr><th>Dest. Branch</th><td>{{ $consignment->destinationBranch->name }}</td></tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <!-- Package Info -->
            <div class="col-md-6">
                <div class="card card-outline card-warning">
                    <div class="card-header py-2">
                        <h5 class="card-title mb-0"><i class="fas fa-boxes mr-2 text-warning"></i>Package & Amount</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm mb-0">
                            <tr><th class="w-50">Item</th><td>{{ $consignment->item_description }}</td></tr>
                            <tr><th>No. of Boxes</th><td>{{ $consignment->no_of_boxes }}</td></tr>
                            <tr><th>Actual Weight</th><td>{{ $consignment->actual_weight }} kg</td></tr>
                            <tr><th>Chargeable Wt.</th><td>{{ $consignment->chargeable_weight }} kg</td></tr>
                            <tr><th>Total Amount</th><td>₹{{ number_format($consignment->total_amount, 2) }}</td></tr>
                            <tr><th>Grand Total</th><td class="font-weight-bold text-success">₹{{ number_format($consignment->grand_total, 2) }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Consigner -->
            <div class="col-md-6">
                <div class="card card-outline card-warning">
                    <div class="card-header py-2">
                        <h5 class="card-title mb-0"><i class="fas fa-user-tie mr-2 text-warning"></i>Consigner</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm mb-0">
                            <tr><th class="w-40">Name</th><td>{{ $consignment->consigner_name }}</td></tr>
                            <tr><th>Address</th><td>{{ $consignment->consigner_address }}</td></tr>
                            @if($consignment->consigner_gst_number)
                            <tr><th>GST</th><td>{{ $consignment->consigner_gst_number }}</td></tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <!-- Consignee -->
            <div class="col-md-6">
                <div class="card card-outline card-success">
                    <div class="card-header py-2">
                        <h5 class="card-title mb-0"><i class="fas fa-user-check mr-2 text-success"></i>Consignee</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm mb-0">
                            <tr><th class="w-40">Name</th><td>{{ $consignment->consignee_name }}</td></tr>
                            <tr><th>Address</th><td>{{ $consignment->consignee_address }}</td></tr>
                            @if($consignment->consignee_gst_number)
                            <tr><th>GST</th><td>{{ $consignment->consignee_gst_number }}</td></tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if($consignment->final_remark)
        <div class="callout callout-info">
            <h6><i class="fas fa-comment mr-1"></i>Final Remark</h6>
            <p class="mb-0">{{ $consignment->final_remark }}</p>
        </div>
        @endif

        @if($consignment->createdBy)
        <small class="text-muted">
            <i class="fas fa-user mr-1"></i>Booked by {{ $consignment->createdBy->name }}
            on {{ $consignment->created_at->format('d M Y h:i A') }}
        </small>
        @endif

    </div>

    <!-- Right: Status Update + Timeline -->
    <div class="col-md-4">

        <!-- Update Status -->
        <div class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-sync-alt mr-2"></i>Update Status</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.consignments.update-status', $consignment->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>New Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            @foreach($allStatuses as $key => $label)
                                <option value="{{ $key }}" {{ $consignment->delivery_status === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Current Location <small class="text-muted">(optional)</small></label>
                        <input type="text" name="location" class="form-control"
                               placeholder="e.g. Mumbai Hub, Delhi Warehouse...">
                    </div>
                    <div class="form-group">
                        <label>Comment <small class="text-muted">(optional)</small></label>
                        <textarea name="comment" class="form-control" rows="3"
                                  placeholder="Add a note about this status update..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger btn-block">
                        <i class="fas fa-save mr-2"></i>Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Status Timeline -->
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-history mr-2"></i>Status Timeline
                    <span class="badge badge-primary ml-1">{{ $consignment->statusLogs->count() }}</span>
                </h3>
            </div>
            <div class="card-body p-3" style="max-height:500px;overflow-y:auto;">
                @if($consignment->statusLogs->count() > 0)
                <div class="timeline timeline-inverse">
                    @foreach($consignment->statusLogs as $log)
                    <div class="time-label">
                        <span class="bg-{{ \App\Models\Consignment::getStatusBadgeClass($log->status) }}">
                            {{ $log->created_at->format('d M Y') }}
                        </span>
                    </div>
                    <div>
                        <i class="fas {{ \App\Models\Consignment::getStatusIconClass($log->status) }} bg-{{ \App\Models\Consignment::getStatusBadgeClass($log->status) }}"></i>
                        <div class="timeline-item">
                            <span class="time">
                                <i class="fas fa-clock"></i>
                                {{ $log->created_at->format('h:i A') }}
                            </span>
                            <h3 class="timeline-header">
                                <strong>{{ $allStatuses[$log->status] ?? $log->status }}</strong>
                            </h3>
                            @if($log->location)
                            <div class="timeline-body text-muted small">
                                <i class="fas fa-map-marker-alt mr-1"></i>{{ $log->location }}
                            </div>
                            @endif
                            @if($log->comment)
                            <div class="timeline-body">{{ $log->comment }}</div>
                            @endif
                            <div class="timeline-footer">
                                <small class="text-muted">
                                    <i class="fas fa-user mr-1"></i>{{ $log->admin->name ?? 'System' }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div><i class="fas fa-clock bg-gray"></i></div>
                </div>
                @else
                <div class="text-center text-muted py-3">
                    <i class="fas fa-history fa-2x mb-2 d-block"></i>
                    No status history yet.
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('CN Number copied: ' + text);
    }).catch(function() {
        var el = document.createElement('textarea');
        el.value = text;
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);
        alert('CN Number copied: ' + text);
    });
}
</script>
@endpush
