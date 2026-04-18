@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<!-- Stats Row -->
<div class="row">
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total'] }}</h3>
                <p>Total Consignments</p>
            </div>
            <div class="icon"><i class="fas fa-boxes"></i></div>
            <a href="{{ route('admin.consignments.index') }}" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['today'] }}</h3>
                <p>Today's Bookings</p>
            </div>
            <div class="icon"><i class="fas fa-calendar-day"></i></div>
            <a href="{{ route('admin.consignments.index') }}" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $stats['in_transit'] }}</h3>
                <p>In Transit</p>
            </div>
            <div class="icon"><i class="fas fa-truck"></i></div>
            <a href="{{ route('admin.consignments.index', ['status' => 'in_transit']) }}" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $statusCounts['out_for_delivery'] ?? 0 }}</h3>
                <p>Out for Delivery</p>
            </div>
            <div class="icon"><i class="fas fa-motorcycle"></i></div>
            <a href="{{ route('admin.consignments.index', ['status' => 'out_for_delivery']) }}" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['delivered'] }}</h3>
                <p>Delivered</p>
            </div>
            <div class="icon"><i class="fas fa-check-circle"></i></div>
            <a href="{{ route('admin.consignments.index', ['status' => 'delivered']) }}" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="small-box bg-dark">
            <div class="inner">
                <h3>{{ $stats['pod_updated'] }}</h3>
                <p>POD Updated</p>
            </div>
            <div class="icon"><i class="fas fa-file-signature"></i></div>
            <a href="{{ route('admin.consignments.index', ['status' => 'pod_updated']) }}" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<!-- Status Breakdown & Quick Actions -->
<div class="row">
    <!-- Status Breakdown -->
    <div class="col-md-5">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i>Status Breakdown</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th class="text-right">Count</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allStatuses as $key => $label)
                        <tr>
                            <td>
                                <span class="badge badge-{{ \App\Models\Consignment::getStatusBadgeClass($key) }}">
                                    {{ $label }}
                                </span>
                            </td>
                            <td class="text-right font-weight-bold">{{ $statusCounts[$key] ?? 0 }}</td>
                            <td class="text-right">
                                <a href="{{ route('admin.consignments.index', ['status' => $key]) }}" class="btn btn-xs btn-outline-primary">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-md-3">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-bolt mr-2"></i>Quick Actions</h3>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.consignments.create') }}" class="btn btn-primary btn-block mb-2">
                    <i class="fas fa-plus-circle mr-2"></i>New Booking
                </a>
                <a href="{{ route('admin.consignments.index') }}" class="btn btn-info btn-block mb-2">
                    <i class="fas fa-list mr-2"></i>All Consignments
                </a>
                <a href="{{ route('tracking.index') }}" target="_blank" class="btn btn-secondary btn-block">
                    <i class="fas fa-search mr-2"></i>Track Shipment
                </a>
            </div>
        </div>
    </div>

    <!-- Today info -->
    <div class="col-md-4">
        <div class="card card-outline card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Today's Summary</h3>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Date:</strong> {{ now()->format('d M Y') }}</p>
                <p class="mb-1"><strong>New Bookings:</strong> {{ $stats['today'] }}</p>
                <p class="mb-1"><strong>In Transit:</strong> {{ $stats['in_transit'] }}</p>
                <p class="mb-1"><strong>Out for Delivery:</strong> {{ $statusCounts['out_for_delivery'] ?? 0 }}</p>
                <p class="mb-0"><strong>Delivered:</strong> {{ $stats['delivered'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Consignments -->
<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-history mr-2"></i>Recent Consignments</h3>
                <div class="card-tools d-flex align-items-center">
                    <form method="GET" action="{{ route('admin.consignments.index') }}" class="mr-2">
                        <div class="input-group input-group-sm" style="width:260px;">
                            <input type="text" name="search" class="form-control"
                                   placeholder="Search CN / Tracking No..."
                                   value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <a href="{{ route('admin.consignments.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-sm table-hover table-striped">
                    <thead>
                        <tr>
                            <th>CN Number</th>
                            <th>Tracking = CN</th>
                            <th>Booking Date</th>
                            <th>Consigner</th>
                            <th>Consignee</th>
                            <th>Origin</th>
                            <th>Destination</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentConsignments as $c)
                        <tr>
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
                            <td>{{ $c->origin }}</td>
                            <td>{{ $c->destination }}</td>
                            <td>
                                <span class="badge badge-{{ \App\Models\Consignment::getStatusBadgeClass($c->delivery_status) }}">
                                    {{ \App\Models\Consignment::getStatuses()[$c->delivery_status] ?? $c->delivery_status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.consignments.show', $c->id) }}" class="btn btn-xs btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                No consignments yet. <a href="{{ route('admin.consignments.create') }}">Create the first one</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
