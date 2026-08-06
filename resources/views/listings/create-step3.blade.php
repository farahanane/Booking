<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tourist - Add Formulas</title>
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
                <h1 class="display-3 text-white animated slideInDown">Add Formulas</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ route('listings.index') }}">Home</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Add Formulas</li>
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
                <h6 class="text-white text-uppercase">Add Formulas</h6>
                <h1 class="text-white mb-4">Add Formulas for {{ $listing->title }}</h1>
                <p class="mb-4">Define additional pricing formulas (e.g., meal plans) to enhance your hotel’s offerings with customizable charges.</p>
            </div>
            <div class="col-md-6">
                <form action="{{ route('listings.store-step3', $listing->id) }}" method="POST">
                    @csrf
                    <div id="formulas-container">
                        <div class="formula-row">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-control bg-transparent" name="formulas[0][formula_name]" required>
                                            <option value="">Select Formula</option>
                                            <option value="Logement seul (+0 TND)">Logement seul</option>
                                            <option value="Petit déjeuner (+10 TND)">Petit déjeuner </option>
                                            <option value="Demi pension (+30 TND)">Demi pension </option>
                                            <option value="Demi pension Plus (+40 TND)">Demi pension Plus</option>
                                            <option value="Pension complète (+50 TND)">Pension complète</option>
                                            <option value="All inclusive soft (+70 TND)">All inclusive soft</option>
                                            <option value="All inclusive (+80 TND)">All inclusive</option>
                                        </select>
                                        <label>Formula Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" step="0.01" class="form-control bg-transparent" name="formulas[0][additional_price]" placeholder="Additional Price" required>
                                        <label>Additional Price (DT)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-formula" class="btn btn-outline-light mt-3">Add Formula</button>
                    <button type="submit" class="btn btn-outline-light w-100 py-3 mt-3">Finish</button>
                </form>
                <script>
                    let formulaIndex = 1;
                    document.getElementById('add-formula').addEventListener('click', () => {
                        const container = document.getElementById('formulas-container');
                        const row = document.createElement('div');
                        row.className = 'formula-row mt-3';
                        row.innerHTML = `
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-control bg-transparent" name="formulas[${formulaIndex}][formula_name]" required>
                                            <option value="">Select Formula</option>
                                            <option value="Logement seul (+0 TND)">Logement seul </option>
                                            <option value="Petit déjeuner (+10 TND)">Petit déjeuner </option>
                                            <option value="Demi pension (+30 TND)">Demi pension</option>
                                            <option value="Demi pension Plus (+40 TND)">Demi pension Plus </option>
                                            <option value="Pension complète (+50 TND)">Pension complète </option>
                                            <option value="All inclusive soft (+70 TND)">All inclusive soft </option>
                                            <option value="All inclusive (+80 TND)">All inclusive</option>
                                        </select>
                                        <label>Formula Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" step="0.01" class="form-control bg-transparent" name="formulas[${formulaIndex}][additional_price]" placeholder="Additional Price" required>
                                        <label>Additional Price (DT)</label>
                                    </div>
                                </div>
                            </div>
                        `;
                        container.appendChild(row);
                        formulaIndex++;
                    });
                </script>
            </div>
        </div>
    </div>
    @endsection
</body>
</html>