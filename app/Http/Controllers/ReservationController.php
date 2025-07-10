<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'listing_id' => 'required|exists:listings,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'number_of_travelers' => 'required|integer|min:1',
        ]);

        $listing = Listing::findOrFail($request->listing_id);
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $number_of_travelers = $request->number_of_travelers;
        $rooms_needed = ceil($number_of_travelers / 2);

        // Check availability
        $has_conflicting_reservations = $listing->reservations()->where(function ($query) use ($start_date, $end_date) {
            $query->whereBetween('start_date', [$start_date, $end_date])
                  ->orWhereBetween('end_date', [$start_date, $end_date])
                  ->orWhere(function ($q) use ($start_date, $end_date) {
                      $q->where('start_date', '<=', $start_date)
                        ->where('end_date', '>=', $end_date);
                  });
        })->exists();

        if ($has_conflicting_reservations) {
            return redirect()->back()->withErrors(['start_date' => 'The selected dates are not available.']);
        }

        if ($listing->number_of_rooms < $rooms_needed) {
            return redirect()->back()->withErrors(['number_of_travelers' => 'Not enough rooms available for the selected number of travelers.']);
        }

        // Calculate total price
        $days = $start_date->diffInDays($end_date);
        $total_price = $days * $listing->price_per_night;

        // Create reservation
        Reservation::create([
            'listing_id' => $listing->id,
            'user_id' => Auth::id(), // Set user_id to authenticated user's ID
            'start_date' => $start_date,
            'end_date' => $end_date,
            'number_of_travelers' => $number_of_travelers,
            'total_price' => $total_price,
        ]);

        \Log::info('Reservation created', [
            'user_id' => Auth::id(),
            'listing_id' => $listing->id,
            'start_date' => $start_date->toDateString(),
            'end_date' => $end_date->toDateString(),
            'number_of_travelers' => $number_of_travelers,
            'total_price' => $total_price,
        ]);

        return redirect()->route('listings.index')->with('success', 'Reservation created successfully.');
    }
    
}