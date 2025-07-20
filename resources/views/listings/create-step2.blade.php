<!-- resources/views/listings/create-step2.blade.php -->
@extends('layouts.app')

@section('title', 'Add New Listing - Step 2')
@section('hero-content')
    <div class="container text-center">
        <h6 class="text-white text-uppercase">Add Hotel</h6>
        <h1 class="text-white mb-4">Add New Hotel - Step 2: Room Types & Meal Plans</h1>
        <p class="text-white mb-4">Select room types and set prices, then choose available meal plans for your hotel.</p>
    </div>
@endsection

@section('content')
    <div class="col-md-12 text-white">
        <form method="POST" action="{{ route('listings.store-step2', $listing->id) }}">
            @csrf
        <input type="hidden" name="meal_plans" value="">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h3>Room Types</h3>
            <div id="room-types">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select class="form-control bg-transparent" name="room_types[0][name]" required>
                                <option value="">Select Room Type</option>
                                <option value="Chambre Double Standard">Chambre Double Standard</option>
                                <option value="Suite Double">Suite Double</option>
                                <option value="Chambre Double Superieure">Chambre Double Superieure</option>
                                <option value="Chambre Double Vue Mer">Chambre Double Vue Mer</option>
                            </select>
                            <label for="room_type">Room Type</label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-floating">
                            <input type="number" step="0.01" class="form-control bg-transparent" name="room_types[0][price]" placeholder="Price" required>
                            <label for="price">Price (DT)</label>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-outline-light mt-4" id="add-room-type">Add</button>
                    </div>
                </div>
            </div>

            <h3 class="mt-4">Meal Plans for Hotel</h3>
            <div class="row">
                <div class="col-md-12">
                    <label>Available Meal Plans:</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="meal_plans[]" value="Logement seul (+0 TND)">
                                <label class="form-check-label">Logement seul (+0 TND)</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="meal_plans[]" value="Petit déjeuner (+10 TND)">
                                <label class="form-check-label">Petit déjeuner (+10 TND)</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="meal_plans[]" value="Demi pension (+30 TND)">
                                <label class="form-check-label">Demi pension (+30 TND)</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="meal_plans[]" value="Demi pension Plus (+40 TND)">
                                <label class="form-check-label">Demi pension Plus (+40 TND)</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="meal_plans[]" value="Pension complète (+50 TND)">
                                <label class="form-check-label">Pension complète (+50 TND)</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="meal_plans[]" value="All inclusive soft (+70 TND)">
                                <label class="form-check-label">All inclusive soft (+70 TND)</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="meal_plans[]" value="All inclusive (+80 TND)">
                                <label class="form-check-label">All inclusive (+80 TND)</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-outline-light w-100 py-3">Save Listing</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('add-room-type').addEventListener('click', function() {
            const container = document.getElementById('room-types');
            const index = container.children.length;
            const row = document.createElement('div');
            row.className = 'row g-3 mb-3';
            row.innerHTML = `
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-control bg-transparent" name="room_types[${index}][name]" required>
                            <option value="">Select Room Type</option>
                            <option value="Chambre Double Standard">Chambre Double Standard</option>
                            <option value="Suite Double">Suite Double</option>
                            <option value="Chambre Double Superieure">Chambre Double Superieure</option>
                            <option value="Chambre Double Vue Mer">Chambre Double Vue Mer</option>
                        </select>
                        <label for="room_type">Room Type</label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-floating">
                        <input type="number" step="0.01" class="form-control bg-transparent" name="room_types[${index}][price]" placeholder="Price" required>
                        <label for="price">Price (DT)</label>
                    </div>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-outline-danger mt-4" onclick="this.parentElement.parentElement.remove()">Remove</button>
                </div>
            `;
            container.appendChild(row);
        });
    </script>
@endsection