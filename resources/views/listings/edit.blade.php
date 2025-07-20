<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tourist - Listings</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="travel listings, vacation rentals" name="keywords">
    <meta content="Explore our exclusive vacation rentals and accommodations at Tourist." name="description">

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
                    <a href="#" class="nav-item nav-link"></a>
                 
                </div>
                @if (Auth::check())
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary rounded-pill py-2 px-4">Logout</button>
                    </form>
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary rounded-pill py-2 px-4">Register</a>
                @endif
            </div>
        </nav>

        <div class="container-fluid bg-primary py-5 mb-5 hero-header">
        </div>
    </div>
    <!-- Navbar & Hero End -->
    <!-- Booking Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="booking p-5">
                <div class="row g-5 align-items-center">
                    <div class="col-md-6 text-white">
                        <h6 class="text-white text-uppercase">Edit Hotel</h6>
                        <h1 class="text-white mb-4">Update Hotel Details</h1>
                        <p class="mb-4">Discover your perfect getaway with our curated selection of vacation rentals and accommodations. Whether you're seeking a cozy beachfront villa, a luxurious mountain retreat, or a charming city apartment, our hotels offer unparalleled comfort and style.</p>
                    </div>
                    <div class="col-md-6">
                        <h1 class="text-white mb-4">Hotel Details</h1>
                        @if (isset($listing))
                            <form method="POST" action="{{ route('listings.update', $listing->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control bg-transparent" name="title" id="title" placeholder="Title" value="{{ old('title', $listing->title) }}" required>
                                            <label for="title">Title</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <textarea class="form-control bg-transparent" name="description" id="description" placeholder="Description" style="height: 100px">{{ old('description', $listing->description) }}</textarea>
                                            <label for="description">Description</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                           <select class="form-control bg-transparent" name="hotel_category" id="hotel_category" required>
                                                <option value="">Select Category</option>
                                                <option value="★☆☆☆☆" {{ old('hotel_category', $listing->hotel_category) === '★☆☆☆☆' ? 'selected' : '' }}>★☆☆☆☆ (1 Star)</option>
                                                <option value="★★☆☆☆" {{ old('hotel_category', $listing->hotel_category) === '★★☆☆☆' ? 'selected' : '' }}>★★☆☆☆ (2 Stars)</option>
                                                <option value="★★★☆☆" {{ old('hotel_category', $listing->hotel_category) === '★★★☆☆' ? 'selected' : '' }}>★★★☆☆ (3 Stars)</option>
                                                <option value="★★★★☆" {{ old('hotel_category', $listing->hotel_category) === '★★★★☆' ? 'selected' : '' }}>★★★★☆ (4 Stars)</option>
                                                <option value="★★★★★" {{ old('hotel_category', $listing->hotel_category) === '★★★★★' ? 'selected' : '' }}>★★★★★ (5 Stars)</option>
                                            </select>

                                            <label for="hotel_category">Hotel Category</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-control bg-transparent" name="location_country" id="location_country" required>
                                                <option value="">Select Country</option>
                                                <option value="Tunisia" {{ old('location_country', $listing->location_country) === 'Tunisia' ? 'selected' : '' }}>Tunisia</option>
                                                <option value="France" {{ old('location_country', $listing->location_country) === 'France' ? 'selected' : '' }}>France</option>
                                                <option value="Spain" {{ old('location_country', $listing->location_country) === 'Spain' ? 'selected' : '' }}>Spain</option>
                                            </select>
                                            <label for="location_country">Country</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control bg-transparent" name="location_city" id="location_city" placeholder="City / Town / Region" value="{{ old('location_city', $listing->location_city) }}" required>
                                            <label for="location_city">City / Town / Region</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="number" class="form-control bg-transparent" name="number_of_rooms" id="number_of_rooms" placeholder="Number of Rooms" value="{{ old('number_of_rooms', $listing->number_of_rooms) }}" required>
                                            <label for="number_of_rooms">Number of Rooms</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="number" class="form-control bg-transparent" name="price_per_night" id="price_per_night" placeholder="Price per Night" value="{{ old('price_per_night', $listing->price_per_night) }}" required>
                                            <label for="price_per_night">Price per Night</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="file" class="form-control bg-transparent" name="images[]" id="images" multiple>
                                            <label for="images">Images (Up to 10, leave blank to keep current)</label>
                                        </div>
                                    </div>
                                    @if ($listing->image_url)
                                        <div class="col-md-12">
                                            <label>Current Images:</label><br>
                                            @php
                                                $images = is_array($listing->image_url) ? $listing->image_url : json_decode($listing->image_url, true);
                                                $firstImage = !empty($images) ? $images[0] : 'img/placeholder.jpg';
                                            @endphp
                                            <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $listing->title }}" class="img-fluid" style="max-width: 200px; margin-top: 10px;">
                                        </div>
                                    @endif
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="email" class="form-control bg-transparent" name="hotel_email" id="hotel_email" placeholder="Hotel Email Address" value="{{ old('hotel_email', $listing->hotel_email) }}" required>
                                            <label for="hotel_email">Hotel Email Address</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-outline-light w-100 py-3">Update Hotel</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <p class="text-danger">Listing not found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Booking End -->

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
</body>
</html>