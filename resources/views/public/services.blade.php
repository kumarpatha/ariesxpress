@extends('layouts.public')

@section('title', 'Services - Cargo Logistics & Shipping Services')

@section('content')
    <section class="page-header">
        <div class="container">
            <h1>Our Services</h1>
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a> / <span>Services</span>
            </nav>
        </div>
    </section>

    <section class="page-content">
        <div class="container">
            <div class="services-detail">
                <div class="service-detail-item">
                    <div class="service-image">
                        <img src="{{ asset('assets/img/air-cargo2_.jpg') }}" alt="Air Cargo">
                    </div>
                    <div class="service-text">
                        <h2>Air Cargo</h2>
                        <p>AXL provides fast and reliable air cargo services for time-sensitive shipments, backed by dependable carrier partnerships and careful cargo handling.</p>
                        <ul>
                            <li>Express delivery for urgent shipments</li>
                            <li>Door-to-door service</li>
                            <li>Real-time tracking support</li>
                            <li>Secure handling of valuable cargo</li>
                            <li>Nationwide coverage</li>
                        </ul>
                    </div>
                </div>

                <div class="service-detail-item">
                    <div class="service-image">
                        <img src="{{ asset('assets/img/train-cargo.jpg') }}" alt="Train Cargo">
                    </div>
                    <div class="service-text">
                        <h2>Train Cargo</h2>
                        <p>Our train cargo services offer an economical and efficient solution for bulk shipments by leveraging India’s extensive railway network.</p>
                        <ul>
                            <li>Cost-effective for bulk shipments</li>
                            <li>Wide network coverage</li>
                            <li>Safe and secure transportation</li>
                            <li>Regular scheduled services</li>
                            <li>Ideal for heavy and oversized cargo</li>
                        </ul>
                    </div>
                </div>

                <div class="service-detail-item">
                    <div class="service-image">
                        <img src="{{ asset('assets/img/surface.jpg') }}" alt="Surface Express Cargo">
                    </div>
                    <div class="service-text">
                        <h2>Surface Express Cargo</h2>
                        <p>Our surface express cargo service provides reliable road transportation solutions supported by an operational fleet and consistent movement planning.</p>
                        <ul>
                            <li>Door-to-door delivery</li>
                            <li>Part truck load services</li>
                            <li>Full truck load services</li>
                            <li>Express delivery options</li>
                            <li>Online tracking facility</li>
                        </ul>
                    </div>
                </div>

                <div class="service-detail-item">
                    <div class="service-image">
                        <img src="{{ asset('assets/img/warehousing_.jpg') }}" alt="Warehousing">
                    </div>
                    <div class="service-text">
                        <h2>Warehousing</h2>
                        <p>AXL offers warehouse support through strategically located facilities designed for organized storage, monitoring, and inventory handling.</p>
                        <ul>
                            <li>Strategic locations across India</li>
                            <li>Modern storage facilities</li>
                            <li>Inventory management support</li>
                            <li>Secure and monitored storage</li>
                            <li>Value-added logistics services</li>
                        </ul>
                    </div>
                </div>

                <div class="service-detail-item">
                    <div class="service-image">
                        <img src="{{ asset('assets/img/record.jpg') }}" alt="Packaging Solutions">
                    </div>
                    <div class="service-text">
                        <h2>Packaging Solutions</h2>
                        <p>We provide customized packaging solutions that protect products during transit, including PVC packing, wooden crating, and specialized protective methods.</p>
                        <ul>
                            <li>Customized packaging solutions</li>
                            <li>PVC packing for quality handling</li>
                            <li>Wooden crating services</li>
                            <li>Protective packaging for fragile items</li>
                            <li>Expert packaging consultation</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection