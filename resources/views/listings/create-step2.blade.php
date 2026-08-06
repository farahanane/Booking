<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tourist - Add Rooms</title>
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
                <h1 class="display-3 text-white animated slideInDown">Add Rooms</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ route('listings.index') }}">Home</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Add Rooms</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    @endsection

    @section('content')
    <div class="booking p-5">
        <div class="row g-5 align-items-center">
                <form action="{{ route('listings.store-step2', $listing->id) }}" method="POST">
                    @csrf
                    <div id="rooms-container">
                        <div class="room-row">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <select class="form-control bg-transparent" name="rooms[0][room_type]" required>
                                            <option value="">Select Room Type</option>
                                            <option value="Single">Single</option>
                                            <option value="Double">Double</option>
                                            <option value="Triple">Triple</option>
                                            <option value="Suite">Suite</option>
                                        </select>
                                        <label>Room Type</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="date" class="form-control bg-transparent" name="rooms[0][start_date]" required>
                                        <label>Start Date</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="date" class="form-control bg-transparent" name="rooms[0][end_date]" required>
                                        <label>End Date</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="number" step="0.01" class="form-control bg-transparent" name="rooms[0][price]" placeholder="Price" required>
                                        <label>Price (DT)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-room" class="btn btn-outline-light mt-3">Add Room</button>
                    <button type="submit" class="btn btn-outline-light w-100 py-3 mt-3">Next</button>
                </form>
                <script>
                    let roomIndex = 1;
                    document.getElementById('add-room').addEventListener('click', () => {
                        const container = document.getElementById('rooms-container');
                        const row = document.createElement('div');
                        row.className = 'room-row mt-3';
                        row.innerHTML = `
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <select class="form-control bg-transparent" name="rooms[${roomIndex}][room_type]" required>
                                            <option value="">Select Room Type</option>
                                            <option value="Single">Single</option>
                                            <option value="Double">Double</option>
                                            <option value="Triple">Triple</option>
                                            <option value="Suite">Suite</option>
                                        </select>
                                        <label>Room Type</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="date" class="form-control bg-transparent" name="rooms[${roomIndex}][start_date]" required>
                                        <label>Start Date</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="date" class="form-control bg-transparent" name="rooms[${roomIndex}][end_date]" required>
                                        <label>End Date</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="number" step="0.01" class="form-control bg-transparent" name="rooms[${roomIndex}][price]" placeholder="Price" required>
                                        <label>Price (DT)</label>
                                    </div>
                                </div>
                            </div>
                        `;
                        container.appendChild(row);
                        roomIndex++;
                    });
                </script>
            </div>
    </div>
    @endsection
</body>
</html>