@extends('layouts.public')

@section('title', 'Track Your Shipment | Aries Xpress Logistics Pvt. Ltd')

@section('page_styles')
<style>
    .tracking-page {
        background: linear-gradient(180deg, #f5f9ff 0%, #ffffff 100%);
        padding: 60px 0;
    }
    .tracking-intro {
        text-align: center;
        margin-bottom: 35px;
    }
    .tracking-intro h1 {
        color: #0066cc;
        font-size: 38px;
        margin-bottom: 10px;
    }
    .tracking-intro p {
        color: #666;
        max-width: 680px;
        margin: 0 auto;
    }
    .tracking-card {
        max-width: 680px;
        margin: 0 auto;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        padding: 35px;
    }
    .tracking-form-block label {
        display: block;
        margin-bottom: 10px;
        color: #0066cc;
        font-weight: 600;
    }
    .tracking-form-block input {
        width: 100%;
        padding: 14px 16px;
        border: 1px solid #d8e2f0;
        border-radius: 6px;
        font-size: 15px;
        text-transform: uppercase;
        margin-bottom: 12px;
    }
    .tracking-form-block button {
        background-color: #0066cc;
        color: #fff;
        border: none;
        padding: 14px 22px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 15px;
    }
    .tracking-form-block button:hover {
        background-color: #0052a3;
    }
    .tracking-error {
        background: #fff4f4;
        border: 1px solid #f1c2c7;
        color: #b02a37;
        padding: 14px 16px;
        border-radius: 6px;
        margin-bottom: 18px;
    }
    .tracking-note {
        margin-top: 12px;
        color: #666;
        font-size: 14px;
    }
</style>
@endsection

@section('content')
    <section class="page-header">
        <div class="container">
            <h1>Track Shipment</h1>
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a> / <span>Tracking</span>
            </nav>
        </div>
    </section>

    <section class="tracking-page">
        <div class="container">
            <div class="tracking-intro">
                <h1>Track Your Consignment</h1>
                <p>Enter the consignment note number issued for your shipment to view the latest movement and delivery status.</p>
            </div>

            <div class="tracking-card">
                @if($errors->any())
                <div class="tracking-error">
                    {{ $errors->first() }}
                </div>
                @endif

                <form action="{{ route('tracking.track') }}" method="POST" class="tracking-form-block">
                    @csrf
                    <label for="tracking_number">Consignment Number</label>
                    <input id="tracking_number" type="text" name="tracking_number" placeholder="e.g. CN000123" value="{{ old('tracking_number') }}" required>
                    <button type="submit">Track Shipment</button>
                    <p class="tracking-note">Use the same consignment note number printed on your receipt. This is also the tracking number for your shipment.</p>
                </form>
            </div>
        </div>
    </section>
@endsection
