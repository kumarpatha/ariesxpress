<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $consignment->tracking_number }} | Track Shipment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f4f6f9; }
        .top-bar {
            background: linear-gradient(135deg, #0062cc 0%, #003d80 100%);
            color: #fff;
            padding: 16px 0;
        }
        .top-bar h5 { margin: 0; font-weight: 700; }
        .cn-banner {
            background: #fff;
            border-left: 5px solid #007bff;
            border-radius: 8px;
            padding: 1.2rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .cn-number { font-size: 1.6rem; font-weight: 700; color: #007bff; letter-spacing: 1px; }
        /* Progress Steps */
        .progress-steps { display: flex; justify-content: space-between; margin-bottom: 2rem; }
        .step { flex: 1; text-align: center; position: relative; }
        .step::before {
            content: '';
            position: absolute;
            top: 20px;
            left: -50%;
            width: 100%;
            height: 3px;
            background: #dee2e6;
            z-index: 0;
        }
        .step:first-child::before { display: none; }
        .step.completed::before { background: #28a745; }
        .step.current::before { background: #28a745; }
        .step .step-circle {
            width: 42px; height: 42px;
            border-radius: 50%;
            background: #dee2e6;
            color: #6c757d;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 6px;
            position: relative; z-index: 1;
            font-size: 1rem;
            border: 3px solid #dee2e6;
        }
        .step.completed .step-circle {
            background: #28a745;
            border-color: #28a745;
            color: #fff;
        }
        .step.current .step-circle {
            background: #007bff;
            border-color: #007bff;
            color: #fff;
            box-shadow: 0 0 0 4px rgba(0,123,255,0.25);
        }
        .step small { font-size: 0.7rem; color: #6c757d; display: block; line-height: 1.2; }
        .step.completed small, .step.current small { color: #343a40; font-weight: 600; }

        /* Timeline */
        .timeline { position: relative; padding-left: 1.5rem; }
        .timeline::before {
            content: ''; position: absolute;
            left: 16px; top: 0; bottom: 0;
            width: 2px; background: #dee2e6;
        }
        .timeline-item { position: relative; margin-bottom: 1.5rem; }
        .timeline-dot {
            position: absolute; left: -1.6rem;
            width: 32px; height: 32px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 0.85rem;
            z-index: 1;
        }
        .timeline-content {
            background: #fff;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            margin-left: 0.5rem;
        }
        .timeline-content .status-title {
            font-weight: 700; font-size: 1rem; margin-bottom: 2px;
        }
        .timeline-time { font-size: 0.8rem; color: #6c757d; }

        .badge-booking { background: #6c757d; }
        .badge-dispatched { background: #17a2b8; }
        .badge-in_transit { background: #007bff; }
        .badge-arrived_at_destination { background: #ffc107; color: #212529; }
        .badge-out_for_delivery { background: #fd7e14; }
        .badge-delivered { background: #28a745; }
        .badge-pod_updated { background: #343a40; }

        .info-table th { width: 40%; font-weight: 600; color: #495057; }
        .info-table td { color: #212529; }
        .footer-bar { background: #343a40; color: rgba(255,255,255,0.6); padding: 12px 0; text-align: center; font-size: 0.85rem; margin-top: 2rem; }
    </style>
</head>
<body>

<div class="top-bar">
    <div class="container d-flex justify-content-between align-items-center">
        <h5><img src="{{ asset('logo.jpg') }}" alt="Aries Logo" class="mr-2" style="height: 35px; width: auto; vertical-align: middle;">Aries Xpress Logistics Pvt. Ltd</h5>
    </div>
</div>

<div class="container mt-4">

    @php
        $steps = [
            'booking'                => ['label' => 'Booking', 'icon' => 'fa-clipboard-check', 'bg' => '#6c757d'],
            'dispatched'             => ['label' => 'Dispatched', 'icon' => 'fa-paper-plane', 'bg' => '#17a2b8'],
            'in_transit'             => ['label' => 'In Transit', 'icon' => 'fa-truck', 'bg' => '#007bff'],
            'arrived_at_destination' => ['label' => 'Arrived', 'icon' => 'fa-warehouse', 'bg' => '#ffc107'],
            'out_for_delivery'       => ['label' => 'Out for Delivery', 'icon' => 'fa-motorcycle', 'bg' => '#fd7e14'],
            'delivered'              => ['label' => 'Delivered', 'icon' => 'fa-check-circle', 'bg' => '#28a745'],
            'pod_updated'            => ['label' => 'POD Updated', 'icon' => 'fa-file-signature', 'bg' => '#343a40'],
        ];
        $stepKeys   = array_keys($steps);
        $currentIdx = array_search($consignment->delivery_status, $stepKeys);
    @endphp

    <!-- CN Banner -->
    <div class="cn-banner">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <small class="text-muted">Tracking Number</small>
                <div class="cn-number">{{ $consignment->tracking_number }}</div>
                <small class="text-muted d-block mt-1">
                    CN: <strong>{{ $consignment->consignment_note_number }}</strong>
                    &bull; Booked on {{ $consignment->booking_date->format('d M Y') }}
                    &bull; {{ $consignment->origin }} → {{ $consignment->destination }}
                </small>
            </div>
            <div class="mt-2 mt-md-0">
                @php $bgColors = ['booking'=>'secondary','dispatched'=>'info','in_transit'=>'primary','arrived_at_destination'=>'warning','out_for_delivery'=>'orange','delivered'=>'success','pod_updated'=>'dark']; @endphp
                <span class="badge badge-{{ $bgColors[$consignment->delivery_status] ?? 'secondary' }} p-2" style="font-size:0.9rem;">
                    <i class="fas {{ $steps[$consignment->delivery_status]['icon'] ?? 'fa-circle' }} mr-1"></i>
                    {{ $steps[$consignment->delivery_status]['label'] ?? $consignment->delivery_status }}
                </span>
            </div>
        </div>
    </div>

    <!-- Progress Steps -->
    <div class="card mb-4">
        <div class="card-body py-4">
            <div class="progress-steps">
                @foreach($steps as $key => $step)
                @php
                    $idx = array_search($key, $stepKeys);
                    $class = '';
                    if ($idx < $currentIdx) $class = 'completed';
                    elseif ($idx === $currentIdx) $class = 'current';
                @endphp
                <div class="step {{ $class }}">
                    <div class="step-circle" style="{{ $class === 'current' ? 'background:' . $step['bg'] . ';border-color:' . $step['bg'] : '' }}">
                        @if($class === 'completed')
                            <i class="fas fa-check"></i>
                        @else
                            <i class="fas {{ $step['icon'] }}"></i>
                        @endif
                    </div>
                    <small>{{ $step['label'] }}</small>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Shipment Info -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-info-circle mr-2 text-primary"></i>Shipment Details</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm info-table mb-0">
                        <tr>
                            <th>Item</th>
                            <td>{{ $consignment->item_description }}</td>
                        </tr>
                        <tr>
                            <th>From</th>
                            <td>{{ $consignment->origin }}</td>
                        </tr>
                        <tr>
                            <th>To</th>
                            <td>{{ $consignment->destination }}</td>
                        </tr>
                        <tr>
                            <th>Sender</th>
                            <td>{{ $consignment->consigner_name }}</td>
                        </tr>
                        <tr>
                            <th>Receiver</th>
                            <td>{{ $consignment->consignee_name }}</td>
                        </tr>
                        <tr>
                            <th>Mode</th>
                            <td><span class="badge badge-secondary">{{ strtoupper($consignment->service_mode) }}</span></td>
                        </tr>
                        <tr>
                            <th>Boxes</th>
                            <td>{{ $consignment->no_of_boxes }}</td>
                        </tr>
                        <tr>
                            <th>Weight</th>
                            <td>{{ $consignment->actual_weight }} kg</td>
                        </tr>
                        <tr>
                            <th>Booking</th>
                            <td>{{ $consignment->booking_date->format('d M Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('tracking.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-search mr-1"></i>Track Another Shipment
                </a>
            </div>
        </div>

        <!-- Status Timeline -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="fas fa-history mr-2 text-primary"></i>Tracking History</h6>
                    <span class="badge badge-primary">{{ $consignment->statusLogs->count() }} updates</span>
                </div>
                <div class="card-body">
                    @if($consignment->statusLogs->count() > 0)
                    <div class="timeline">
                        @foreach($consignment->statusLogs->sortByDesc('created_at') as $log)
                        @php $info = $steps[$log->status] ?? ['label' => $log->status, 'icon' => 'fa-circle', 'bg' => '#6c757d']; @endphp
                        <div class="timeline-item">
                            <div class="timeline-dot" style="background: {{ $info['bg'] }}">
                                <i class="fas {{ $info['icon'] }}"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="status-title">{{ $info['label'] }}</div>
                                @if($log->location)
                                <div class="text-muted small mb-1">
                                    <i class="fas fa-map-marker-alt mr-1"></i>{{ $log->location }}
                                </div>
                                @endif
                                @if($log->comment)
                                <p class="mb-1 text-secondary">{{ $log->comment }}</p>
                                @endif
                                <div class="timeline-time">
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ $log->created_at->format('d M Y, h:i A') }}
                                    ({{ $log->created_at->diffForHumans() }})
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-history fa-2x mb-2 d-block"></i>
                        No tracking updates available yet.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer-bar">
    &copy; {{ date('Y') }} Aries Xpress Logistics Pvt. Ltd. All rights reserved.
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
