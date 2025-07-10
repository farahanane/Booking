<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;

Route::apiResource('listings', ListingController::class);
Route::apiResource('reservations', ReservationController::class);
Route::apiResource('reviews', ReviewController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

