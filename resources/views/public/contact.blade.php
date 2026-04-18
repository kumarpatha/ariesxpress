@extends('layouts.public')

@section('title', 'Contact Us - Cargo Logistics & Shipping Services')

@section('content')
    <section class="page-header">
        <div class="container">
            <h1>Contact Us</h1>
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a> / <span>Contact</span>
            </nav>
        </div>
    </section>

    <section class="page-content">
        <div class="container">
            <div class="contact-wrapper">
                <div class="contact-info">
                    <h2>Get in Touch</h2>
                    <div class="contact-details">
                        <div class="contact-item">
                            <h3>Head Office</h3>
                            <p>ARIES XPRESS LOGISTICS PVT. LTD</p>
                            <p>Godown No. 3, Vyapari Building, Gyani Border,
                                <br>Opposite metro pillar No. 161,
                                <br>Sahibabad, Ghaziabad - 201005</p>
                        </div>
                        <div class="contact-item">
                            <h3>Contact Information</h3>
                            <p><strong>Phone:</strong> <a href="tel:+917839313973">+91 7839313973</a></p>
                            <p><strong>Email:</strong> <a href="mailto:info@ariesxpress.com">info@ariesxpress.com</a></p>
                        </div>
                        <div class="contact-item">
                            <h3>Business Hours</h3>
                            <p>Monday - Friday: 9:00 AM - 6:00 PM</p>
                            <p>Saturday: 9:00 AM - 2:00 PM</p>
                            <p>Sunday: Closed</p>
                        </div>
                        <div class="contact-item">
                            <h3>Follow Us</h3>
                            <div class="contact-social">
                                <a href="#" target="_blank"><img src="{{ asset('assets/img/facebook.jpg') }}" alt="Facebook"></a>
                                <a href="#" target="_blank"><img src="{{ asset('assets/img/twitter.jpg') }}" alt="Twitter"></a>
                                <a href="#" target="_blank"><img src="{{ asset('assets/img/in.jpg') }}" alt="LinkedIn"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="contact-form-wrapper">
                    <h2>Send us a Message</h2>
                    <form class="contact-form" id="contactForm" action="{{ route('inquiries.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="form_type" value="contact">
                        <div class="form-group">
                            <input type="text" name="user_name" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <input type="tel" name="user_phone" placeholder="Mobile No" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="user_email" placeholder="Email Id" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="user_city" placeholder="City" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="subject" placeholder="Subject" required>
                        </div>
                        <div class="form-group">
                            <textarea name="message" placeholder="Your Message" rows="6" required></textarea>
                        </div>
                        <div id="form-message" style="display: none; margin-bottom: 15px; padding: 10px; border-radius: 4px;"></div>
                        <button type="submit" class="submit-btn" id="submitBtn">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection