<!-- resources/views/listings/create-step1.blade.php -->
@extends('layouts.app')

@section('title', 'Add New Listing - Step 1')
@section('hero-content')
    <div class="container text-center">
        <h6 class="text-white text-uppercase">Add Hotel</h6>
        <h1 class="text-white mb-4">Add New Hotel - Step 1: Basic Info</h1>
        <p class="text-white mb-4">Enter the basic details of your hotel to get started.</p>
    </div>
@endsection

@section('content')
    <div class="col-md-12 text-white">
        <form method="POST" action="{{ route('listings.store-step1') }}" enctype="multipart/form-data">
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
                        <input type="number" class="form-control bg-transparent" name="number_of_rooms" id="number_of_rooms" placeholder="Number of Rooms" required min="1">
                        <label for="number_of_rooms">Number of Rooms</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="file" class="form-control bg-transparent" name="images[]" id="images" multiple>
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
@endsection