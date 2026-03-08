@extends('admin.layouts.app')

@section('title', 'All Consignments')
@section('page-title', 'Consignments')

@section('breadcrumb')
    <li class="breadcrumb-item active">All Consignments</li>
@endsection

@section('content')
<!-- Filters -->
<div class="card card-outline card-primary mb-3">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-filter mr-2"></i>Filter & Search</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.consignments.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Search</label>
                        <input type="text" name="search" class="form-control"
                               placeholder="CN number, tracking no, name, phone..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="">All Statuses</option>
                            @foreach($allStatuses as $key => $label)
                                <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Date From</label>
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Date To</label>
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <div class="form-group w-100">
                        <button type="submit" class="btn btn-primary mr-2">
                            <i class="fas fa-search mr-1"></i>Search
                        </button>
                        <a href="{{ route('admin.consignments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times mr-1"></i>Clear
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Consignments Table -->
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-list mr-2"></i>
            Consignments
            <span class="badge badge-primary ml-2">{{ $consignments->total() }}</span>
        </h3>
        <div class="card-tools">
            <a href="{{ route('admin.consignments.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus mr-1"></i>New Booking
            </a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-sm table-hover table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>CN Number</th>
                    <th>Tracking No.</th>
                    <th>Booking Date</th>
                    <th>Consigner</th>
                    <th>Consignee</th>
                    <th>Phone</th>
                    <th>Origin</th>
                    <th>Destination</th>
                    <th>Mode</th>
                    <th>Grand Total</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($consignments as $c)
                <tr>
                    <td>{{ $loop->iteration + ($consignments->currentPage() - 1) * $consignments->perPage() }}</td>
                    <td>
                        <a href="{{ route('admin.consignments.show', $c->id) }}" class="font-weight-bold text-primary">
                            {{ $c->consignment_note_number }}
                        </a>
                    </td>
                    <td>
                        <span class="text-secondary font-weight-bold">{{ $c->tracking_number }}</span>
                    </td>
                    <td>{{ $c->booking_date->format('d M Y') }}</td>
                    <td>{{ $c->consigner_name }}</td>
                    <td>{{ $c->consignee_name }}</td>
                    <td>{{ $c->phone_number }}</td>
                    <td>{{ $c->origin }}</td>
                    <td>{{ $c->destination }}</td>
                    <td>
                        <span class="badge badge-secondary">
                            {{ strtoupper($c->service_mode) }}
                        </span>
                    </td>
                    <td class="text-right">₹{{ number_format($c->grand_total, 2) }}</td>
                    <td>
                        <span class="badge badge-{{ \App\Models\Consignment::getStatusBadgeClass($c->delivery_status) }}">
                            {{ $allStatuses[$c->delivery_status] ?? $c->delivery_status }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.consignments.show', $c->id) }}"
                           class="btn btn-xs btn-primary" title="View & Update Status">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.consignments.edit', $c->id) }}"
                           class="btn btn-xs btn-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="13" class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                        No consignments found.
                        <a href="{{ route('admin.consignments.create') }}">Create first booking</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($consignments->hasPages())
    <div class="card-footer clearfix">
        <div class="float-right">
            {{ $consignments->links() }}
        </div>
        <small class="text-muted">
            Showing {{ $consignments->firstItem() }}–{{ $consignments->lastItem() }}
            of {{ $consignments->total() }} records
        </small>
    </div>
    @endif
</div>
@endsection
