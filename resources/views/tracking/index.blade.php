<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Shipment | Aries Xpress Logistics Pvt. Ltd</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0062cc 0%, #003d80 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .track-hero {
            padding: 60px 0 40px;
            color: #fff;
            text-align: center;
        }
        .track-hero h1 { font-size: 2.5rem; font-weight: 700; }
        .track-hero p { font-size: 1.1rem; opacity: 0.85; }
        .track-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 2rem;
            max-width: 540px;
            margin: 0 auto 60px;
        }
        .footer-bar {
            margin-top: auto;
            background: rgba(0,0,0,0.2);
            color: rgba(255,255,255,0.7);
            padding: 12px 0;
            text-align: center;
            font-size: 0.85rem;
        }
        .input-icon { position: relative; }
        .input-icon .form-control { padding-left: 40px; }
        .input-icon .icon {
            position: absolute; left: 12px; top: 50%;
            transform: translateY(-50%); color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="track-hero">
        <div class="container">
            <img src="{{ asset('logo.jpg') }}" alt="Aries Logo" class="mb-3 d-block mx-auto" style="height: 80px; width: auto;">
            <h1>Track Your Shipment</h1>
            <p>Enter your Tracking Number and registered phone number to track your shipment.</p>
        </div>
    </div>

    <div class="container">
        <div class="track-card">
            <h5 class="font-weight-bold mb-4 text-center">
                <i class="fas fa-search-location mr-2 text-primary"></i>Shipment Tracker
            </h5>

            @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('tracking.track') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="font-weight-bold">Tracking Number</label>
                    <div class="input-icon">
                        <i class="icon fas fa-hashtag"></i>
                        <input type="text"
                               name="tracking_number"
                               class="form-control form-control-lg @error('tracking_number') is-invalid @enderror"
                               placeholder="e.g. TRK-20260308-00001"
                               value="{{ old('tracking_number') }}"
                               style="text-transform:uppercase"
                               required>
                    </div>
                    <small class="text-muted">The Tracking Number is printed on your consignment receipt.</small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Registered Phone Number</label>
                    <div class="input-icon">
                        <i class="icon fas fa-phone"></i>
                        <input type="text"
                               name="phone_number"
                               class="form-control form-control-lg @error('phone_number') is-invalid @enderror"
                               placeholder="e.g. 9876543210"
                               value="{{ old('phone_number') }}"
                               required>
                    </div>
                    <small class="text-muted">The phone number provided at the time of booking.</small>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg mt-3">
                    <i class="fas fa-search mr-2"></i>Track Shipment
                </button>
            </form>

            <hr>
        </div>
    </div>

    <div class="footer-bar">
        &copy; {{ date('Y') }} Aries Xpress Logistics Pvt. Ltd. All rights reserved.
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-uppercase the CN input
        document.querySelector('[name="tracking_number"]').addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    </script>
</body>
</html>
