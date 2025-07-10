<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tourist - Admin Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="travel listings, vacation rentals" name="keywords">
    <meta content="Admin dashboard to manage hotel listings and reservations for Tourist." name="description">
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

    <!-- Custom Styles for Search and Filter -->
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

        .navbar {
            padding: 15px 0; /* Matches reservations navbar padding */
        }

        .navbar .navbar-nav.left-filters {
            flex-grow: 1;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: 120px; /* Matches reservations left shift */
            padding: 20px 0; /* Matches reservations vertical padding */
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
                <input type="text" id="searchInput" class="form-control-custom" placeholder="Search hotels..." value="{{ request()->query('search') }}">
                <select id="cityFilter" class="form-control-custom" name="location_city">
                    <option value="" {{ !request()->query('location_city') ? 'selected' : '' }}>All Cities</option>
                    <option value="Hammamet" {{ request()->query('location_city') == 'Hammamet' ? 'selected' : '' }}>Hammamet</option>
                    <option value="Sousse" {{ request()->query('location_city') == 'Sousse' ? 'selected' : '' }}>Sousse</option>
                    <option value="Mahdia" {{ request()->query('location_city') == 'Mahdia' ? 'selected' : '' }}>Mahdia</option>
                    <option value="Monastir" {{ request()->query('location_city') == 'Monastir' ? 'selected' : '' }}>Monastir</option>
                    <option value="Djerba" {{ request()->query('location_city') == 'Djerba' ? 'selected' : '' }}>Djerba</option>
                    <option value="Nabeul" {{ request()->query('location_city') == 'Nabeul' ? 'selected' : '' }}>Nabeul</option>
                </select>
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

    <!-- Dashboard Start -->
    @if (Auth::check() && Auth::user()->email === 'admin@gmail.com')
    <div class="dashboard">
        <header class="menu-wrap">
            <figure class="user">
                <div class="user-avatar">
                </div>
            </figure>
            <nav>
                <section class="tools">
                    <h3>Tools</h3>
                    <ul>
                        <li>
                            <a href="{{ route('auth.dashboard') }}" class="active">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"/></svg>
                                Hotels
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('auth.reservations') }}">
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
                <h2>Hotel Listings</h2>
                <div class="text-end mb-4">
                    <a href="{{ route('listings.create') }}" class="add-listing-btn">
                        <span class="icon"><i class="fas fa-plus"></i></span> Add new hotel
                    </a>
                </div>
            </header>
            <div class="content">
                <div class="row" id="listingsContainer">
                    @foreach ($listings as $listing)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="overflow-hidden">
                                @php
                                    $images = $listing->image_url;
                                    $firstImage = (is_array($images) && !empty($images)) ? $images[0] : (is_string($images) ? json_decode($images, true)[0] ?? null : null);
                                @endphp
                                @if ($firstImage)
                                    <img class="img-fluid" src="{{ asset('storage/' . $firstImage) }}" alt="{{ $listing->title }}" style="height: 300px; object-fit: cover;">
                                @else
                                    <img class="img-fluid" src="img/placeholder.jpg" alt="No Image" style="height: 200px; object-fit: cover;">
                                @endif
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $listing->title }}</h5>
                                <p class="card-text"><i class="fas fa-map-marker-alt me-2"></i>{{ $listing->location_city }}</p>
                                <p class="card-text"><strong>{{ number_format($listing->price_per_night, 2) }} DT</strong></p>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('listings.edit', $listing->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('listings.destroy', $listing->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this hotel?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- Pagination -->
                <div class="pagination justify-content-center mt-4" id="paginationContainer">
                    {{ $listings->links('pagination::bootstrap-4', ['prev' => '<span class="bi bi-chevron-left"></span>', 'next' => '<span class="bi bi-chevron-right"></span>']) }}
                </div>
            </div>
        </main>
    </div>
    @else
    <div class="container">
        <div class="alert alert-danger">
            Access denied. Only admin users can view this page.
        </div>
    </div>
    @endif
    <!-- Dashboard End -->

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

    <!-- Custom Search and City Filter Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const cityFilter = document.getElementById('cityFilter');
            const listingsContainer = document.getElementById('listingsContainer');
            const paginationContainer = document.getElementById('paginationContainer');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-danger mt-3';
            errorDiv.style.display = 'none';
            document.querySelector('.content').appendChild(errorDiv);

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

            // Handle search and city filter
            const handleSearchFilter = debounce(function() {
                const query = searchInput.value.trim();
                const city = cityFilter.value;
                errorDiv.style.display = 'none'; // Hide error message
                const url = new URL(`{{ route('auth.dashboard') }}`, window.location.origin);
                if (query) url.searchParams.append('search', encodeURIComponent(query));
                if (city) url.searchParams.append('location_city', city);

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
                    const newListings = doc.querySelector('#listingsContainer');
                    const newPagination = doc.querySelector('#paginationContainer');
                    if (newListings && newPagination) {
                        listingsContainer.innerHTML = newListings.innerHTML;
                        paginationContainer.innerHTML = newPagination.innerHTML;
                        // Add prev-next class to pagination arrows after update
                        const prevItem = paginationContainer.querySelector('.page-item:first-child');
                        const nextItem = paginationContainer.querySelector('.page-item:last-child');
                        if (prevItem) prevItem.classList.add('prev-next');
                        if (nextItem) nextItem.classList.add('prev-next');
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

            searchInput.addEventListener('input', handleSearchFilter);
            cityFilter.addEventListener('change', handleSearchFilter);

            // Initial addition of prev-next class on page load
            const pagination = document.querySelector('#paginationContainer');
            if (pagination) {
                const prevItem = pagination.querySelector('.page-item:first-child');
                const nextItem = pagination.querySelector('.page-item:last-child');
                if (prevItem) prevItem.classList.add('prev-next');
                if (nextItem) nextItem.classList.add('prev-next');
            }
        });
    </script>
</body>
</html>