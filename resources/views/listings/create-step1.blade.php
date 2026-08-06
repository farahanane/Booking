<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tourist - Add Hotel</title>
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
    @extends('layouts.app')

    @section('hero-content')
    <div class="container py-5">
        <div class="row justify-content-center py-5">
            <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                <h1 class="display-3 text-white animated slideInDown">Add Hotel</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ route('listings.index') }}">Home</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Add Hotel</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    @endsection

    @section('content')
    <div class="booking p-5">
        <div class="row g-5 align-items-center">
            <div class="col-md-6 text-white">
                <h6 class="text-white text-uppercase">Add Hotel</h6>
                <h1 class="text-white mb-4">Add New Hotel</h1>
                <p class="mb-4">Discover your perfect getaway with our curated selection of vacation rentals and accommodations. Whether you're seeking a cozy beachfront villa, a luxurious mountain retreat, or a charming city apartment, our hotels offer unparalleled comfort and style.</p>
            </div>
            <div class="col-md-6">
                <form action="{{ route('listings.store-step1') }}" method="POST" enctype="multipart/form-data">
                    @csrf
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
                                <input type="text" class="form-control bg-transparent" name="title" id="title" placeholder="Title" required>
                                <label for="title">Title</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <textarea class="form-control bg-transparent" name="description" id="description" placeholder="Description" style="height: 100px"></textarea>
                                <label for="description">Description</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <select class="form-control bg-transparent" name="hotel_category" id="hotel_category" required>
                                    <option value="">Select Category</option>
                                    <option value="★★★☆☆">★★★☆☆ (3 Stars)</option>
                                    <option value="★★★★☆">★★★★☆ (4 Stars)</option>
                                    <option value="★★★★★">★★★★★ (5 Stars)</option>
                                </select>
                                <label for="hotel_category">Hotel Category</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-control bg-transparent" name="location_country" id="location_country" required>
                                    <option value="">Select Country</option>
                                    <option value="Tunisia">Tunisia</option>
                                    <option value="France">France</option>
                                    <option value="Spain">Spain</option>
                                </select>
                                <label for="location_country">Country</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-transparent" name="location_city" id="location_city" placeholder="City / Town / Region" required>
                                <label for="location_city">City / Town / Region</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" class="form-control bg-transparent" name="number_of_rooms" id="number_of_rooms" placeholder="Number of Rooms" required>
                                <label for="number_of_rooms">Number of Rooms</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Note: Removed price_per_night as it's now handled by rooms -->
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="file" class="form-control bg-transparent" name="images[]" id="images" multiple required>
                                <label for="images">Images (Up to 10)</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="email" class="form-control bg-transparent" name="hotel_email" id="hotel_email" placeholder="Hotel Email Address" required>
                                <label for="hotel_email">Hotel Email Address</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-outline-light w-100 py-3">Next</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection
</body>
</html>