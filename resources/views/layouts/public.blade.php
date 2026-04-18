<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aries Xpress Logistics Pvt. Ltd')</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/img/logo.jpg') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles.css') }}">
    @yield('page_styles')
</head>
<body data-email-endpoint="{{ route('inquiries.store') }}">
    <header class="main-header">
        <div class="container">
            <div class="header-top">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('assets/img/logo.jpg') }}" alt="Logo">
                        <div class="company-info">
                            <span class="company-name">Aries Xpress Logistics Pvt. Ltd</span>
                            <span class="company-since">Since 2010</span>
                        </div>
                    </a>
                </div>
                <div class="header-right">
                    <div class="social-icons">
                        <a href="#" target="_blank"><img src="{{ asset('assets/img/facebook.jpg') }}" alt="Facebook"></a>
                        <a href="#" target="_blank"><img src="{{ asset('assets/img/twitter.jpg') }}" alt="Twitter"></a>
                        <a href="#" target="_blank"><img src="{{ asset('assets/img/in.jpg') }}" alt="LinkedIn"></a>
                    </div>
                    <button class="quote-btn" onclick="openQuoteModal()">Request A Quote</button>
                </div>
            </div>
        </div>
    </header>

    <nav class="main-nav">
        <div class="container">
            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <ul class="nav-menu" id="navMenu">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
                <li><a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'active' : '' }}">Services</a></li>
                <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
                <li><a href="{{ route('tracking.index') }}" class="{{ request()->routeIs('tracking.*') ? 'active' : '' }}">Tracking</a></li>
            </ul>
        </div>
    </nav>

    @yield('content')

    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h4>Navigation</h4>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('about') }}">About</a></li>
                        <li><a href="{{ route('services') }}">Services</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                        <li><a href="{{ route('tracking.index') }}">Tracking</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>ARIES XPRESS LOGISTICS PVT. LTD</h4>
                    <p>Godown No. 3, Vyapari Building, Gyani Border,
                        <br>Opposite metro pillar No. 161,
                        <br>Sahibabad, Ghaziabad - 201005</p>
                    <p>Email: <a href="mailto:info@ariesxpress.com">info@ariesxpress.com</a></p>
                    <p>Phone: <a href="tel:+917839313973">+91 7839313973</a></p>
                    <div class="footer-social">
                        <a href="#" target="_blank"><img src="{{ asset('assets/img/facebook.jpg') }}" alt="Facebook"></a>
                        <a href="#" target="_blank"><img src="{{ asset('assets/img/twitter.jpg') }}" alt="Twitter"></a>
                        <a href="#" target="_blank"><img src="{{ asset('assets/img/in.jpg') }}" alt="LinkedIn"></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>Copyright @ {{ date('Y') }} AXL. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <div id="quoteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeQuoteModal()">&times;</span>
            <h2>Request A Quote</h2>
            <form class="quote-form" id="quoteForm" action="{{ route('inquiries.store') }}" method="POST">
                @csrf
                <input type="hidden" name="form_type" value="quote">
                <input type="text" name="user_name" placeholder="Name" required>
                <input type="tel" name="user_phone" placeholder="Mobile No" required>
                <input type="email" name="user_email" placeholder="Email Id" required>
                <input type="text" name="user_city" placeholder="City" required>
                <textarea name="query" placeholder="Query" rows="5" required></textarea>
                <div id="quote-form-message" style="display: none; margin-bottom: 15px; padding: 10px; border-radius: 4px;"></div>
                <button type="submit" id="quoteSubmitBtn">Submit</button>
            </form>
        </div>
    </div>

    <script src="{{ asset('assets/public-site.js') }}"></script>
    @yield('page_scripts')
</body>
</html>