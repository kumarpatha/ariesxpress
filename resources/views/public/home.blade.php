@extends('layouts.public')

@section('title', 'Cargo Services – Cargo Logistics & Shipping Services in India')

@section('content')
    <section class="slider-section">
        <div class="slider-container">
            <div class="slider">
                <div class="slide active">
                    <img src="{{ asset('assets/img/banner_1a.jpg') }}" alt="Banner">
                </div>
                <div class="slide">
                    <img src="{{ asset('assets/img/banner_1.jpg') }}" alt="Banner">
                </div>
                <div class="slide">
                    <img src="{{ asset('assets/img/banner_2.jpg') }}" alt="Banner">
                </div>
                <div class="slide">
                    <img src="{{ asset('assets/img/banner_3.jpg') }}" alt="Banner">
                </div>
                <div class="slide">
                    <img src="{{ asset('assets/img/banner_4.jpg') }}" alt="Banner">
                </div>
            </div>
            <div class="quick-actions-overlay">
                <div class="container">
                    <div class="action-box">
                        <div class="action-box-header">
                            <img src="{{ asset('assets/img/track-icon.png') }}" alt="Track">
                        </div>
                        <form class="track-form" action="{{ route('tracking.track') }}" method="POST">
                            @csrf
                            <input type="text" name="tracking_number" placeholder="Docket No" value="{{ old('tracking_number') }}" required>
                            <button type="submit">Track Now</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="slider-controls">
                <a href="#" class="slider-dot active" data-slide="0"></a>
                <a href="#" class="slider-dot" data-slide="1"></a>
                <a href="#" class="slider-dot" data-slide="2"></a>
                <a href="#" class="slider-dot" data-slide="3"></a>
                <a href="#" class="slider-dot" data-slide="4"></a>
            </div>
        </div>
    </section>

    @if($errors->has('tracking_number'))
    <section class="page-content" style="padding-top: 0;">
        <div class="container">
            <div style="background: #fff4f4; color: #b02a37; border: 1px solid #f1c2c7; padding: 14px 18px; border-radius: 6px; margin-bottom: 10px;">
                {{ $errors->first('tracking_number') }}
            </div>
        </div>
    </section>
    @endif

    <section class="services-section">
        <div class="container">
            <h2 class="section-title">What<br>We Do</h2>
            <div class="services-grid">
                <div class="service-card">
                    <a href="{{ route('services') }}">
                        <div class="service-image-wrapper">
                            <img src="{{ asset('assets/img/air-cargo2_.jpg') }}" alt="Air Cargo">
                            <h3>Air Cargo</h3>
                        </div>
                    </a>
                </div>
                <div class="service-card">
                    <a href="{{ route('services') }}">
                        <div class="service-image-wrapper">
                            <img src="{{ asset('assets/img/train-cargo.jpg') }}" alt="Train Cargo">
                            <h3>Train Cargo</h3>
                        </div>
                    </a>
                </div>
                <div class="service-card">
                    <a href="{{ route('services') }}">
                        <div class="service-image-wrapper">
                            <img src="{{ asset('assets/img/surface.jpg') }}" alt="Surface Express Cargo">
                            <h3>Surface Express<br>Cargo</h3>
                        </div>
                    </a>
                </div>
                <div class="service-card">
                    <a href="{{ route('services') }}">
                        <div class="service-image-wrapper">
                            <img src="{{ asset('assets/img/warehousing_.jpg') }}" alt="Warehousing">
                            <h3>Warehousing</h3>
                        </div>
                    </a>
                </div>
                <div class="service-card">
                    <a href="{{ route('services') }}">
                        <div class="service-image-wrapper">
                            <img src="{{ asset('assets/img/record.jpg') }}" alt="Packaging Solutions">
                            <h3>Packaging Solutions</h3>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="why-choose-section">
        <div class="container">
            <h2 class="section-title">WHY CHOOSE US</h2>
            <div class="why-choose-content">
                <div class="why-item">
                    <div class="why-item-header">
                        <h3>Expert Team & Competitive Services</h3>
                    </div>
                    <p>Our transport professionals use integrated train and express routes to deliver competitive pricing, faster transit times, and reliable cargo handling across India.</p>
                </div>
                <div class="why-item">
                    <div class="why-item-header">
                        <h3>Dedicated Customer Service</h3>
                    </div>
                    <p>Our support team stays accessible and detail-focused so customers get dependable assistance, shipment updates, and service continuity at every stage.</p>
                </div>
                <div class="why-image">
                    <img src="{{ asset('assets/img/why-choose-us_.png') }}" alt="Why Choose Us">
                </div>
            </div>
        </div>
    </section>
@endsection