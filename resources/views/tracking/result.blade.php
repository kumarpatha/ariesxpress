@extends('layouts.public')

@section('title', $consignment->consignment_note_number . ' | Track Shipment')

@section('page_styles')
<style>
    .tracking-result-page {
        padding: 50px 0 70px;
        background: #f7f9fc;
    }
    .tracking-summary {
        background: #fff;
        border-left: 5px solid #0066cc;
        border-radius: 8px;
        padding: 24px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        margin-bottom: 24px;
    }
    .tracking-number {
        font-size: 28px;
        font-weight: 700;
        color: #0066cc;
        margin: 6px 0;
    }
    .tracking-meta {
        color: #666;
        font-size: 14px;
    }
    .status-pill {
        background: #0066cc;
        color: #fff;
        padding: 10px 16px;
        border-radius: 999px;
        font-size: 14px;
        white-space: nowrap;
    }
    .tracking-summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }
    .progress-panel,
    .tracking-panel {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }
    .progress-panel {
        padding: 26px 20px;
        margin-bottom: 24px;
    }
    .tracking-grid {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 24px;
        align-items: start;
    }
    .progress-steps {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 10px;
        align-items: start;
    }
    .step {
        position: relative;
        text-align: center;
        padding-top: 4px;
    }
    .step::before {
        content: '';
        position: absolute;
        top: 26px;
        left: calc(-50% + 23px);
        width: calc(100% - 6px);
        height: 4px;
        background: linear-gradient(90deg, #d8e3f0 0%, #e6edf5 100%);
        border-radius: 999px;
        z-index: 0;
    }
    .step:first-child::before {
        display: none;
    }
    .step.completed::before,
    .step.current::before {
        background: linear-gradient(90deg, #4d97de 0%, #0066cc 100%);
    }
    .step-circle {
        width: 46px;
        height: 46px;
        margin: 0 auto 10px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #d9e4f2;
        color: #667;
        font-weight: 700;
        position: relative;
        z-index: 1;
        box-shadow: 0 0 0 6px #fff;
    }
    .step.completed .step-circle,
    .step.current .step-circle {
        background: #0066cc;
        color: #fff;
    }
    .step.current .step-circle {
        box-shadow: 0 0 0 6px #fff, 0 0 0 10px rgba(0, 102, 204, 0.14);
    }
    .step small {
        display: block;
        font-size: 12px;
        color: #666;
        line-height: 1.4;
        max-width: 92px;
        margin: 0 auto;
    }
    .tracking-panel {
        padding: 0;
        overflow: hidden;
    }
    .tracking-panel h3 {
        font-size: 18px;
        color: #0066cc;
        margin: 0;
    }
    .panel-header {
        padding: 18px 22px;
        border-bottom: 1px solid #edf1f7;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
    }
    .shipment-table {
        width: 100%;
        border-collapse: collapse;
    }
    .shipment-table th,
    .shipment-table td {
        padding: 12px 18px;
        border-bottom: 1px solid #edf1f7;
        vertical-align: top;
        font-size: 14px;
    }
    .shipment-table th {
        width: 38%;
        color: #4f6177;
        text-align: left;
        font-weight: 600;
    }
    .another-track {
        display: inline-block;
        margin-top: 18px;
        background: #fff;
        border: 1px solid #0066cc;
        color: #0066cc;
        padding: 10px 16px;
        border-radius: 6px;
        text-decoration: none;
    }
    .another-track:hover {
        background: #0066cc;
        color: #fff;
    }
    .timeline {
        padding: 20px 22px 24px;
    }
    .timeline-item {
        position: relative;
        padding-left: 32px;
        margin-bottom: 22px;
    }
    .timeline-item:last-child {
        margin-bottom: 0;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: 8px;
        top: 26px;
        bottom: -22px;
        width: 2px;
        background: #d6e1ef;
    }
    .timeline-item:last-child::before {
        display: none;
    }
    .timeline-dot {
        position: absolute;
        left: 0;
        top: 4px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
    }
    .timeline-title {
        font-weight: 700;
        color: #213549;
        margin-bottom: 4px;
    }
    .timeline-location,
    .timeline-comment,
    .timeline-time {
        color: #666;
        font-size: 14px;
        line-height: 1.6;
    }
    .timeline-empty {
        padding: 28px 22px;
        color: #666;
    }
    .updates-count {
        background: #e9f3ff;
        color: #0066cc;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
    }
    @media (max-width: 960px) {
        .tracking-grid {
            grid-template-columns: 1fr;
        }
        .progress-steps {
            grid-template-columns: repeat(3, 1fr);
            row-gap: 22px;
        }
        .step::before {
            display: none;
        }
    }
    @media (max-width: 640px) {
        .progress-steps {
            grid-template-columns: repeat(2, 1fr);
        }
        .tracking-number {
            font-size: 22px;
        }
    }
</style>
@endsection

@section('content')
    @php
        $steps = [
            'booking' => ['label' => 'Booking', 'bg' => '#6c757d'],
            'dispatched' => ['label' => 'Dispatched', 'bg' => '#17a2b8'],
            'in_transit' => ['label' => 'In Transit', 'bg' => '#007bff'],
            'arrived_at_destination' => ['label' => 'Arrived', 'bg' => '#ffc107'],
            'out_for_delivery' => ['label' => 'Out for Delivery', 'bg' => '#fd7e14'],
            'delivered' => ['label' => 'Delivered', 'bg' => '#28a745'],
            'pod_updated' => ['label' => 'POD Updated', 'bg' => '#343a40'],
        ];
        $stepKeys = array_keys($steps);
        $currentIdx = array_search($consignment->delivery_status, $stepKeys, true);
        $currentStatus = $steps[$consignment->delivery_status]['label'] ?? $consignment->delivery_status;
    @endphp

    <section class="page-header">
        <div class="container">
            <h1>Tracking Result</h1>
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a> / <a href="{{ route('tracking.index') }}">Tracking</a> / <span>{{ $consignment->consignment_note_number }}</span>
            </nav>
        </div>
    </section>

    <section class="tracking-result-page">
        <div class="container">
            <div class="tracking-summary">
                <div class="tracking-summary-row">
                    <div>
                        <div class="tracking-meta">Consignment / Tracking Number</div>
                        <div class="tracking-number">{{ $consignment->consignment_note_number }}</div>
                        <div class="tracking-meta">Booked on {{ $consignment->booking_date->format('d M Y') }} | {{ $consignment->origin }} to {{ $consignment->destination }}</div>
                    </div>
                    <div class="status-pill">{{ $currentStatus }}</div>
                </div>
            </div>

            <div class="progress-panel">
                <div class="progress-steps">
                    @foreach($steps as $key => $step)
                        @php
                            $idx = array_search($key, $stepKeys, true);
                            $class = '';
                            if ($currentIdx !== false && $idx < $currentIdx) {
                                $class = 'completed';
                            } elseif ($currentIdx !== false && $idx === $currentIdx) {
                                $class = 'current';
                            }
                        @endphp
                        <div class="step {{ $class }}">
                            <div class="step-circle" style="{{ $class ? 'background:' . $step['bg'] . ';color:#fff;' : '' }}">
                                {{ $idx + 1 }}
                            </div>
                            <small>{{ $step['label'] }}</small>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="tracking-grid">
                <div>
                    <div class="tracking-panel">
                        <div class="panel-header">
                            <h3>Shipment Details</h3>
                        </div>
                        <table class="shipment-table">
                            <tr><th>Item</th><td>{{ $consignment->item_description ?: 'Not available' }}</td></tr>
                            <tr><th>From</th><td>{{ $consignment->origin }}</td></tr>
                            <tr><th>To</th><td>{{ $consignment->destination }}</td></tr>
                            <tr><th>Sender</th><td>{{ $consignment->consigner_name }}</td></tr>
                            <tr><th>Receiver</th><td>{{ $consignment->consignee_name }}</td></tr>
                            <tr><th>Mode</th><td>{{ strtoupper($consignment->service_mode) }}</td></tr>
                            <tr><th>Boxes</th><td>{{ $consignment->no_of_boxes }}</td></tr>
                            <tr><th>Weight</th><td>{{ $consignment->actual_weight }} kg</td></tr>
                            <tr><th>Booking Date</th><td>{{ $consignment->booking_date->format('d M Y') }}</td></tr>
                        </table>
                    </div>

                    <a href="{{ route('tracking.index') }}" class="another-track">Track Another Shipment</a>
                </div>

                <div class="tracking-panel">
                    <div class="panel-header">
                        <h3>Tracking History</h3>
                        <div class="updates-count">{{ $consignment->statusLogs->count() }} updates</div>
                    </div>

                    @if($consignment->statusLogs->count() > 0)
                        <div class="timeline">
                            @foreach($consignment->statusLogs->sortByDesc('created_at') as $log)
                                @php $info = $steps[$log->status] ?? ['label' => $log->status, 'bg' => '#6c757d']; @endphp
                                <div class="timeline-item">
                                    <div class="timeline-dot" style="background: {{ $info['bg'] }};"></div>
                                    <div class="timeline-title">{{ $info['label'] }}</div>
                                    @if($log->location)
                                    <div class="timeline-location">{{ $log->location }}</div>
                                    @endif
                                    @if($log->comment)
                                    <div class="timeline-comment">{{ $log->comment }}</div>
                                    @endif
                                    <div class="timeline-time">{{ $log->created_at->format('d M Y, h:i A') }} ({{ $log->created_at->diffForHumans() }})</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="timeline-empty">No tracking updates available yet.</div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
