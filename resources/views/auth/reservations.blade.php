<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tourist - Reservations</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="travel listings, vacation rentals" name="keywords">
    <meta content="View and manage your reservations for Tourist." name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

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

    <!-- Custom Dashboard Stylesheet -->
    <link href="{{ asset('css/dashboard.css') }}?v=1" rel="stylesheet">

    <style>
        .table-responsive {
            margin-top: 20px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table th {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
        }
        .table .btn-sm {
            padding: 5px 10px;
        }

        .navbar .navbar-nav.left-filters {
            flex-grow: 1;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: 120px;
            padding: 20px 0;
        }

        .form-control-custom {
            border-radius: 10px;
            padding: 6px 10px;
            border: 1px solid #ced4da;
            font-size: 14px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            width: 200px;
        }

        .form-control-custom:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
            outline: none;
        }

        .date-input {
            width: 120px;
        }

        .navbar .btn-primary {
            border-radius: 20px;
            padding: 8px 20px;
            font-weight: 600;
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
            padding: 0 10px; /* Adjusted padding for non-circular links */
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

        @media (max-width: 768px) {
            .navbar .navbar-nav.left-filters {
                flex-direction: column;
                align-items: stretch;
                padding-top: 10px;
            }
            .form-control-custom, .date-input {
                width: 100%;
                margin-bottom: 5px;
            }
            .navbar-collapse {
                padding: 0;
            }
        }

        /* Action Button Styles */
        .action-btn {
            border-radius: 20px;
            padding: 5px 15px;
            font-size: 14px;
            margin-right: 5px;
        }
        .btn-confirm {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-confirm:hover {
            background-color: #218838;
            border-color: #218838;
        }
        .btn-refuse {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-refuse:hover {
            background-color: #c82333;
            border-color: #c82333;
        }
        .button-group {
    display: inline-flex;
    margin: 0;
}

.button-group form {
    margin: 0;
}

.action-btn {
    border-radius: 20px !important; /* Override any other radius */
    padding: 5px 10px !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    color: #fff !important;
    transition: background-color 0.3s ease;
}

.btn-confirm {
    background-color: #28a745 !important;
    border: none !important;
}

.btn-confirm:hover {
    background-color: #218838 !important;
}

.btn-refuse {
    background-color: #dc3545 !important;
    border: none !important;
}

.btn-refuse:hover {
    background-color: #c82333 !important;
}

.status-text {
    display: block;
    padding: 5px 10px;
    text-align: center;
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

    <!-- Navbar Start -->
    <div class="container-fluid position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
              <a href="{{ route('listings.index') }}" class="navbar-brand p-0 mx-auto">
                <h1 class="text-primary m-0"><i class="fa fa-map-marker-alt me-3"></i>Tourist</h1>
            </a>
            <div class="navbar-nav left-filters">
                <input type="text" id="searchInput" class="form-control-custom" placeholder="Search..." value="{{ request()->query('search') }}">
                <select id="cityFilter" class="form-control-custom" name="location_city">
                    <option value="" {{ !request()->query('location_city') ? 'selected' : '' }}>All Cities</option>
                    <option value="Hammamet" {{ request()->query('location_city') == 'Hammamet' ? 'selected' : '' }}>Hammamet</option>
                    <option value="Sousse" {{ request()->query('location_city') == 'Sousse' ? 'selected' : '' }}>Sousse</option>
                    <option value="Mahdia" {{ request()->query('location_city') == 'Mahdia' ? 'selected' : '' }}>Mahdia</option>
                    <option value="Monastir" {{ request()->query('location_city') == 'Monastir' ? 'selected' : '' }}>Monastir</option>
                    <option value="Djerba" {{ request()->query('location_city') == 'Djerba' ? 'selected' : '' }}>Djerba</option>
                    <option value="Nabeul" {{ request()->query('location_city') == 'Nabeul' ? 'selected' : '' }}>Nabeul</option>
                </select>
                <input type="date" id="checkInDate" class="form-control-custom date-input" value="{{ request()->query('check_in_date') }}">
                <input type="date" id="checkOutDate" class="form-control-custom date-input" value="{{ request()->query('check_out_date') }}">
            </div>
          
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0 d-flex align-items-center">
                    @if (Auth::check())
                        <form method="POST" action="{{ route('logout') }}" class="ms-2">
                            @csrf
                            <button type="submit" class="btn btn-primary">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary ms-2">Register</a>
                    @endif
                </div>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->

    <!-- Reservations Start -->
    @if (Auth::check())
    <div class="dashboard">
        <header class="menu-wrap">
            <figure class="user">
                <div class="user-avatar"></div>
            </figure>
            <nav>
                <section class="tools">
                    <h3>Tools</h3>
                    <ul>
                        <li>
                            <a href="{{ route('auth.dashboard') }}" class="{{ Route::currentRouteName() === 'auth.dashboard' ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"/></svg>
                                Hotels
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('auth.reservations') }}" class="{{ Route::currentRouteName() === 'auth.reservations' ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21 3h-4V2h-2v1H9V2H7v1H3a1 1 0 0 0-1 1v17a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm-1 16H4V9h16v10zM4 6h16v2H4V6z"/></svg>
                                Reservations
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21 4H3a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1zm-1 14H4V9.227l7.335 6.521a1.003 1.003 0 0 0 1.33-.001L20 9.227V18zm0-11.448l-8 7.11-8-7.111V6h16v.552z"/></svg>
                                Messages
                            </a>
                        </li>
                    </ul>
                </section>
            </nav>
        </header>
        <main class="content-wrap">
            <header class="content-head">
                <h2>
                    @if (Auth::user()->email === 'admin@gmail.com') All Reservations @else My Reservations @endif
                </h2>
            </header>
            <div class="content">
                @if ($reservations->count())
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Hotel</th>
                                    <th>Location</th>
                                    @if (Auth::user()->email === 'admin@gmail.com')
                                        <th>Client</th>
                                    @endif
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Travelers</th>
                                    <th>Total Price</th>
                                    @if (Auth::user()->email === 'admin@gmail.com')
                                        <th>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reservations as $reservation)
                                <tr>
                                    <td>
                                        @if ($reservation->listing)
                                            {{ $reservation->listing->title }}
                                        @else
                                            <span class="text-danger">Listing Not Found</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($reservation->listing)
                                            {{ $reservation->listing->location_city }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    @if (Auth::user()->email === 'admin@gmail.com')
                                        <td>{{ $reservation->user->name }} ({{ $reservation->user->email }})</td>
                                    @endif
                                    <td>{{ $reservation->start_date->format('Y-m-d') }}</td>
                                    <td>{{ $reservation->end_date->format('Y-m-d') }}</td>
                                    <td>{{ $reservation->number_of_travelers }} Traveler{{ $reservation->number_of_travelers > 1 ? 's' : '' }}</td>
                                    <td>{{ number_format($reservation->total_price, 2) }} DT</td>
                                    @if (Auth::user()->email === 'admin@gmail.com')
                                        <td>
                                            @if ($reservation->status === 'pending')
                                                <div class="button-group">
                                                    <form action="{{ route('admin.reservations.confirm', $reservation->id) }}" method="POST" style="display:inline; margin: 0;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-confirm action-btn" style="border-radius: 20px 0 0 20px; margin: 0; padding: 5px 10px; font-size: 14px; font-weight: 600; color: #fff; background-color: #28a745; border: none;">Confirm</button>
                                                    </form>
                                                    <form action="{{ route('admin.reservations.refuse', $reservation->id) }}" method="POST" style="display:inline; margin: 0;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-refuse action-btn" style="border-radius: 0 20px 20px 0; margin: 0; padding: 5px 10px; font-size: 14px; font-weight: 600; color: #fff; background-color: #dc3545; border: none;">Refuse</button>
                                                    </form>
                                                </div>
                                            @elseif ($reservation->status === 'confirmed')
                                                <span class="status-text" style="font-size: 14px; font-weight: 600; color: #28a745;">Confirmed</span>
                                            @elseif ($reservation->status === 'refused')
                                                <span class="status-text" style="font-size: 14px; font-weight: 600; color: #dc3545;">Refused</span>
                                            @else
                                                <span class="status-text" style="font-size: 14px; font-weight: 600; color: #6c757d;">Unknown Status</span>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Custom Pagination -->
                    <div class="pagination justify-content-center mt-4">
                        {{ $reservations->links('pagination::bootstrap-4', ['prev' => '<span class="bi bi-chevron-left"></span>', 'next' => '<span class="bi bi-chevron-right"></span>']) }}
                    </div>
                @else
                    <p class="text-center">No reservations found.</p>
                @endif
            </div>
        </main>
    </div>
    @else
    <div class="container">
        <div class="alert alert-danger">
            Access denied. Please log in to view this page.
        </div>
    </div>
    @endif
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
    <script src="{{ asset('lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>

    <!-- Custom Search and Date Filter Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const cityFilter = document.getElementById('cityFilter');
            const checkInDate = document.getElementById('checkInDate');
            const checkOutDate = document.getElementById('checkOutDate');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-danger mt-3';
            errorDiv.style.display = 'none';
            document.querySelector('.content').appendChild(errorDiv);

            // Set CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Debounce function to limit frequent requests
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            // Handle search, city filter, and date filtering
            const handleFilter = debounce(function() {
                const query = searchInput.value.trim();
                const city = cityFilter.value;
                const checkIn = checkInDate.value;
                const checkOut = checkOutDate.value;
                errorDiv.style.display = 'none'; // Hide error message
                const url = new URL(`{{ route('auth.reservations') }}`, window.location.origin);
                if (query) url.searchParams.append('search', encodeURIComponent(query));
                if (city) url.searchParams.append('location_city', city);
                if (checkIn) url.searchParams.append('check_in_date', checkIn);
                if (checkOut) url.searchParams.append('check_out_date', checkOut);

                fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.text();
                })
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.querySelector('.content');
                    if (newContent) {
                        document.querySelector('.content').innerHTML = newContent.innerHTML;
                        // Reinitialize any event listeners if needed
                    } else {
                        throw new Error('Invalid response format');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    errorDiv.textContent = 'Error loading results. Please try again.';
                    errorDiv.style.display = 'block';
                });
            }, 300); // 300ms delay

            searchInput.addEventListener('input', handleFilter);
            cityFilter.addEventListener('change', handleFilter);
            checkInDate.addEventListener('change', handleFilter);
            checkOutDate.addEventListener('change', handleFilter);
        });
    </script>
</body>
</html>