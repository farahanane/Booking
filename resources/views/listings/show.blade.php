<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tourist - {{ $listing->title }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="travel listings, vacation rentals" name="keywords">
    <meta content="Book {{ $listing->title }} at Tourist." name="description">

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Inline Styles -->
    <style>
        .booking-form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .booking-form .form-control,
        .booking-form .form-select {
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        .booking-form .btn {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            border-radius: 30px;
            padding: 10px 30px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }
        .booking-form .btn:hover {
            background: linear-gradient(135deg, #0056b3, #004085);
            transform: translateY(-2px);
        }
        .total-price {
            margin-top: 20px;
            font-size: 1.2rem;
            font-weight: 600;
            color: #2C3E50;
        }
        .carousel-inner img {
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
        }
        .carousel-control-prev,
        .carousel-control-next {
            width: 5%;
        }
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            width: 30px;
            height: 30px;
        }
    </style>
</head>
<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar & Hero Start -->
    <div class="container-fluid position-relative p-0">
         <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
            <a href="{{ route('listings.index') }}" class="navbar-brand p-0">
                <h1 class="text-primary m-0"><i class="fa fa-map-marker-alt me-3"></i>Tourist</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">
                    <a href="{{ route('listings.index') }}" class="nav-item nav-link">Home</a>
                    <a href="about.html" class="nav-item nav-link">About</a>
                    <a href="service.html" class="nav-item nav-link">Services</a>
                    <a href="{{ route('listings.index') }}" class="nav-item nav-link">Hotels</a>
                    @if (Auth::check())
                        <a href="{{ route('profile') }}" class="nav-item nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">Profile</a>
                    @endif
                </div>
                @if (Auth::check())
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary rounded-pill py-2 px-4">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary rounded-pill py-2 px-4">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary rounded-pill py-2 px-4">Register</a>
                @endif
            </div>
        </nav>
        <div class="container-fluid bg-primary py-5 mb-5 hero-header">
            <div class="container py-5">
                <div class="row justify-content-center py-5">
                    <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                        <h1 class="display-3 text-white animated slideInDown">{{ $listing->title }}</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="{{ route('listings.index') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('listings.index') }}">Hotels</a></li>
                                <li class="breadcrumb-item text-white active" aria-current="page">{{ $listing->title }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar & Hero End -->

    <!-- Listing Details Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    @php
                        $images = $listing->image_url;
                        $images = (is_array($images) && !empty($images)) ? $images : (is_string($images) ? json_decode($images, true) ?? [] : []);
                    @endphp
                    <div id="listingCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($images as $index => $image)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $image) }}" class="d-block w-100" alt="{{ $listing->title }} - Image {{ $index + 1 }}">
                                </div>
                            @endforeach
                            @if (empty($images))
                                <div class="carousel-item active">
                                    <img src="{{ asset('img/placeholder.jpg') }}" class="d-block w-100" alt="No Image">
                                </div>
                            @endif
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#listingCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#listingCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h1 class="mb-4">{{ $listing->title }}</h1>
                    <p><i class="fa fa-map-marker-alt text-primary me-2"></i>{{ $listing->location_city }}, {{ $listing->location_country }}</p>
                    <p><i class="fa fa-star text-primary me-2"></i>{{ $listing->hotel_category }}</p>
                    <p><i class="fa fa-bed text-primary me-2"></i>{{ $listing->number_of_rooms }} Rooms</p>
                    <p><i class="fa fa-dollar-sign text-primary me-2"></i>{{ number_format($listing->price_per_night, 2) }} DT per night</p>
                    <p class="mb-4">{{ $listing->description }}</p>
                    <p><i class="fa fa-envelope text-primary me-2"></i>{{ $listing->hotel_email }}</p>
                    @if (Auth::check() && Auth::user()->email === 'admin@gmail.com')
                        <div class="d-flex mb-2">
                            <a href="{{ route('listings.edit', $listing->id) }}" class="btn btn-sm btn-warning px-3 border-end" style="border-radius: 30px 0 0 30px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75l11.06-11.06-3.75-3.75L3 17.25zm14.24-12.24c.39-.39 1.02-.39 1.41 0l2.34 2.34c.39.39.39 1.02 0 1.41L17.83 11.1l-3.75-3.75 3.16-3.24z"/></svg>
                                Edit
                            </a>
                            <form action="{{ route('listings.destroy', $listing->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this listing?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger px-3" style="border-radius: 0 30px 30px 0;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
                <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="booking-form mt-4">
                        <h3 class="mb-4">Book This Hotel</h3>
                        @if (Auth::check())
                            <form action="{{ route('reservations.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="listing_id" value="{{ $listing->id }}">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="start_date" class="form-label">Check-in Date</label>
                                        <input type="date" class="form-control datepicker" name="start_date" id="start_date" value="{{ $start_date ?? '' }}" required>
                                        @if ($errors->has('start_date'))
                                            <span class="text-danger">{{ $errors->first('start_date') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <label for="end_date" class="form-label">Check-out Date</label>
                                        <input type="date" class="form-control datepicker" name="end_date" id="end_date" value="{{ $end_date ?? '' }}" required>
                                        @if ($errors->has('end_date'))
                                            <span class="text-danger">{{ $errors->first('end_date') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <label for="number_of_travelers" class="form-label">Travelers</label>
                                        <select class="form-select" name="number_of_travelers" id="number_of_travelers" required>
                                            <option value="" disabled {{ !$number_of_travelers ? 'selected' : '' }}>Select Travelers</option>
                                            @for ($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}" {{ $number_of_travelers == $i ? 'selected' : '' }}>{{ $i }} Traveler{{ $i > 1 ? 's' : '' }}</option>
                                            @endfor
                                        </select>
                                        @if ($errors->has('number_of_travelers'))
                                            <span class="text-danger">{{ $errors->first('number_of_travelers') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-12">
                                        <div class="total-price" id="total-price" style="display: none;">
                                            <span id="price-breakdown"></span> x <span id="nights"></span> nuits
                                            <br>
                                            Total <span id="total-amount"></span> DT
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary w-100">Book Now</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <p class="text-center">Please <a href="{{ route('login') }}">log in</a> to book this hotel.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Listing Details End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Company</h4>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Privacy Policy</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">FAQs & Help</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Contact</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Houmt Souk, Djerba</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+216 98 765 985</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href="" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href="" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href="" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href="" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Gallery</h4>
                    <div class="row g-2 pt-2">
                        @php
                            $images = $listing->image_url;
                            $images = (is_array($images) && !empty($images)) ? $images : (is_string($images) ? json_decode($images, true) ?? [] : []);
                        @endphp
                        @foreach (array_slice($images, 0, 6) as $image)
                            <div class="col-4">
                                <img class="img-fluid bg-light p-1" src="{{ asset('storage/' . $image) }}" alt="{{ $listing->title }}" style="height: 60px; object-fit: cover;">
                            </div>
                        @endforeach
                        @if (empty($images))
                            <div class="col-4">
                                <img class="img-fluid bg-light p-1" src="{{ asset('img/placeholder.jpg') }}" alt="No Image" style="height: 60px; object-fit: cover;">
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Newsletter</h4>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control border-primary w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            $('.datepicker').datetimepicker({
                format: 'YYYY-MM-DD',
                minDate: moment(),
                useCurrent: false
            });

            $('#start_date').on('change.datetimepicker', function (e) {
                $('#end_date').datetimepicker('minDate', e.date);
                updateTotalPrice();
            });
            $('#end_date').on('change.datetimepicker', function (e) {
                $('#start_date').datetimepicker('maxDate', e.date);
                updateTotalPrice();
            });

            function updateTotalPrice() {
                let startDate = $('#start_date').val();
                let endDate = $('#end_date').val();
                const pricePerNight = {{ $listing->price_per_night }};
                const totalPriceElement = $('#total-price');
                const priceBreakdownElement = $('#price-breakdown');
                const nightsElement = $('#nights');
                const totalAmountElement = $('#total-amount');

                if (startDate && endDate) {
                    const start = moment(startDate);
                    const end = moment(endDate);
                    const nights = end.diff(start, 'days');

                    if (nights > 0) {
                        const totalPrice = pricePerNight * nights;
                        const formattedPricePerNight = pricePerNight.toFixed(2).replace('.', ',');
                        priceBreakdownElement.text(formattedPricePerNight + ' DT');
                        nightsElement.text(nights);
                        totalAmountElement.text(totalPrice.toFixed(2).replace('.', ','));
                        totalPriceElement.show();
                    } else {
                        totalPriceElement.hide();
                    }
                } else {
                    totalPriceElement.hide();
                }
            }

            // Initial call to display total price if query parameters are present
            updateTotalPrice();
        });
    </script>
</body>
</html>