<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tourist - My Reservations</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="travel listings, vacation rentals" name="keywords">
    <meta content="View your reservations at Tourist." name="description">

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
        .sort-bar {
            background: #fff;
            padding: 15px;
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
        }
        .sort-bar .form-control,
        .sort-bar .form-select {
            border-radius: 20px;
            border: 1px solid #dee2e6;
        }
        .sort-bar .btn {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            border-radius: 30px;
            padding: 10px 30px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }
        .sort-bar .btn:hover {
            background: linear-gradient(135deg, #0056b3, #004085);
            transform: translateY(-2px);
        }
        .add-listing-btn {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            color: white;
            padding: 12px 24px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }
        .add-listing-btn:hover {
            background: linear-gradient(135deg, #0056b3, #004085);
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(0, 123, 255, 0.4);
            color: white;
            text-decoration: none;
        }
        .add-listing-btn .icon {
            background: rgba(255, 255, 255, 0.2);
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            transition: all 0.3s ease;
        }
        .add-listing-btn:hover .icon {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }
        .profile-dropdown {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            padding: 8px 15px;
            border-radius: 20px;
            transition: background 0.3s ease;
        }
        .profile-dropdown:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        .profile-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
        }
        .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            min-width: 150px;
            margin-top: 5px;
        }
        .dropdown-item {
            padding: 8px 20px;
            font-weight: 500;
            color: #333;
            transition: background 0.3s ease;
        }
        .dropdown-item:hover {
            background: #007bff;
            color: white;
        }
        /* Custom Pagination Styling */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 10px;
            align-items: center;
        }

        .pagination .page-item {
            display: inline-flex;
        }

        .pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: background 0.3s ease, transform 0.2s ease;
            padding: 0 10px; /* Adjusted padding for non-circular arrows */
        }

        /* Style for page number links */
        .pagination .page-item:not(.prev-next) .page-link {
            width: 40px;
            height: 40px;
            border-radius: 50%; /* Keep page numbers circular */
            background: #007bff;
            font-size: 16px;
        }

        .pagination .page-item:not(.prev-next) .page-link:hover,
        .pagination .page-item:not(.prev-next) .page-link:focus {
            background: #0056b3;
            transform: scale(1.1);
            outline: none;
        }

        .pagination .page-item.active:not(.prev-next) .page-link {
            background: #0056b3;
            font-weight: 600;
        }

        /* Style for previous and next arrow links */
        .pagination .prev-next .page-link {
            background: #007bff;
            font-size: 16px;
        }

        .pagination .prev-next .page-link:hover,
        .pagination .prev-next .page-link:focus {
            background: #0056b3;
            outline: none;
        }

        .pagination .page-link:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
        }

        .pagination .page-link svg {
            width: 16px;
            height: 16px;
        }

       
    </style>
</head>
<body>
   

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
            </div>
            <div class="d-flex align-items-center ms-3">
                @if (Auth::check())
                    <div class="dropdown">
                        <a class="profile-dropdown dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if (Auth::user()->avatar_url)
                                <img src="{{ Auth::user()->avatar_url }}" alt="Avatar" class="profile-avatar">
                            @else
                                <img src="{{ asset('img/avatar.png') }}" alt="Default Avatar" class="profile-avatar">
                            @endif
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('my.reservations') }}">My Reservations</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary rounded-pill py-2 px-4 me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary rounded-pill py-2 px-4">Register</a>
                @endif
            </div>
        </div>
    </nav>
    <!-- Rest of the Hero section remains unchanged -->
    <div class="container-fluid bg-primary py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row justify-content-center py-5">
                <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                    <h1 class="display-3 text-white animated slideInDown">My Reservations</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="{{ route('listings.index') }}">Home</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">My Reservations</li>
                        </ol>
                    </nav>
                    <!-- Sort Bar -->
                    <div class="sort-bar mt-4">
                        <form action="{{ route('my.reservations') }}" method="GET">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="search" value="{{ request()->query('search') }}" placeholder="Search by hotel or location">
                                </div>
                                <div class="col-md-3">
                                    <input type="date" class="form-control datepicker" name="check_in_date" value="{{ request()->query('check_in_date') }}" placeholder="Check-in Date">
                                </div>
                                <div class="col-md-3">
                                    <input type="date" class="form-control datepicker" name="check_out_date" value="{{ request()->query('check_out_date') }}" placeholder="Check-out Date">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Navbar & Hero End -->

    <!-- Reservations Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">My Reservations</h6>
                <h1 class="mb-5">Your Bookings</h1>
            </div>

            @if ($reservations->count())
                @foreach ($reservations as $reservation)
                    <div class="reservation-item wow fadeInUp" data-wow-delay="0.{{ $loop->iteration * 2 - 1 }}s">
                        <div class="row">
                            <div class="col-md-4">
                                <h5 class="mb-1">Hotel: 
                                    @if ($reservation->listing)
                                        {{ $reservation->listing->title }}
                                    @else
                                        <span class="text-danger">Listing Not Found</span>
                                    @endif
                                </h5>
                                <p class="mb-1">Location: 
                                    @if ($reservation->listing)
                                        {{ $reservation->listing->location_city }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-3">
                                <p class="mb-1">Check-in: {{ $reservation->start_date->format('Y-m-d') }}</p>
                                <p class="mb-1">Check-out: {{ $reservation->end_date->format('Y-m-d') }}</p>
                            </div>
                            <div class="col-md-2">
                                <p class="mb-1">Travelers: {{ $reservation->number_of_travelers }} {{ $reservation->number_of_travelers > 1 ? 'Travelers' : 'Traveler' }}</p>
                                <p class="mb-1">Total: {{ number_format($reservation->total_price, 2) }} DT</p>
                            </div>
                            <div class="col-md-3 text-end">
                                <p class="mb-1">Status: 
                                    @if ($reservation->status === 'confirmed')
                                        <span class="status-text status-confirmed">Confirmed</span>
                                    @elseif ($reservation->status === 'refused')
                                        <span class="status-text status-refused">Refused</span>
                                    @else
                                        <span class="status-text status-pending">Pending</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="pagination">
                    {{ $reservations->links('pagination::bootstrap-4', ['prev' => '<span class="bi bi-chevron-left"></span>', 'next' => '<span class="bi bi-chevron-right"></span>']) }}
                </div>
            @else
                <p class="text-center">You have no reservations.</p>
            @endif
        </div>
    </div>
    <!-- Reservations End -->

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
    <!-- Moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="{{ asset('lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script> 
        document.addEventListener('DOMContentLoaded', () => {
            const packageItems = document.querySelectorAll('.package-item');

            // Get search parameters from the form or URL
            const urlParams = new URLSearchParams(window.location.search);
            const locationCity = urlParams.get('location_city') || '';
            const startDate = urlParams.get('start_date') || '';
            const endDate = urlParams.get('end_date') || '';
            const numberOfTravelers = urlParams.get('number_of_travelers') || '';

            packageItems.forEach(item => {
                item.addEventListener('click', (e) => {
                    if (e.target.tagName === 'BUTTON' || e.target.tagName === 'A' || e.target.closest('form')) {
                        e.stopPropagation();
                        return;
                    }
                    const listingId = item.getAttribute('data-listing-id');
                    if (listingId) {
                        // Build the URL with search parameters
                        const queryParams = new URLSearchParams({
                            start_date: startDate,
                            end_date: endDate,
                            number_of_travelers: numberOfTravelers
                        }).toString();
                        window.location.href = `/listings/${listingId}?${queryParams}`;
                    }
                });
            });

            // Initialize datepickers only if Moment.js is loaded
            if (typeof moment !== 'undefined') {
                $('.datepicker').datetimepicker({
                    format: 'YYYY-MM-DD',
                    minDate: moment(),
                    useCurrent: false
                });

                // Ensure end_date is after start_date
                $('#start_date').on('change.datetimepicker', function (e) {
                    $('#end_date').datetimepicker('minDate', e.date);
                });
                $('#end_date').on('change.datetimepicker', function (e) {
                    $('#start_date').datetimepicker('maxDate', e.date);
                });
            } else {
                console.error('Moment.js is not loaded. Please check the script inclusion.');
            }

            // Add prev-next class to pagination arrows
            const pagination = document.querySelector('.pagination');
            if (pagination) {
                const prevItem = pagination.querySelector('.page-item:first-child');
                const nextItem = pagination.querySelector('.page-item:last-child');
                if (prevItem) prevItem.classList.add('prev-next');
                if (nextItem) nextItem.classList.add('prev-next');
            }
        });-->
    </script>
</body>
</html>