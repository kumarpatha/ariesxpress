@extends('layouts.public')

@section('title', 'About - Cargo Logistics & Shipping Services')

@section('content')
    <section class="page-header">
        <div class="container">
            <h1>About AXL</h1>
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a> / <span>About AXL</span>
            </nav>
        </div>
    </section>

    <section class="page-content">
        <div class="container">
            <div class="content-wrapper">
                <h2>Overview</h2>
                <p><b>Aries Xpress Logistics Private Limited</b> was established in 2010 with a core vision of transporting goods through rail networks while offering a cost-effective, eco-friendly, and reliable alternative to road transport for long-distance cargo.</p>
                <p>We fully understand modern cargo distribution needs and provide train and multi-modal logistics connections that balance efficiency, flexibility, and reach.</p>
                <p>The Aries Xpress network is woven around the complex structure of our country through a multimodal model that covers major locations. While maintaining the core strength of train-based distribution on a door-to-door basis, we keep transit reliability at the center of every movement because it remains one of the most important variables for our customers.</p>
            </div>
        </div>
    </section>
@endsection