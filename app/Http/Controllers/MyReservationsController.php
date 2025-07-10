<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MyReservationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Ensure only authenticated users can access
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $checkInDate = $request->input('check_in_date');
        $checkOutDate = $request->input('check_out_date');

        $query = Reservation::where('user_id', Auth::id())->with(['user', 'listing']);

        if ($search) {
            $query->whereHas('listing', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location_city', 'like', "%{$search}%");
            });
        }
        if ($checkInDate) {
            $query->whereDate('start_date', $checkInDate);
        }
        if ($checkOutDate) {
            $query->whereDate('end_date', $checkOutDate);
        }

        $query->orderBy('start_date', 'asc');

        $reservations = $query->paginate(5);

        Log::info('My Reservations viewed', [
            'user_id' => Auth::id(),
            'search' => $search,
            'check_in_date' => $checkInDate,
            'check_out_date' => $checkOutDate,
            'reservations_count' => $reservations->count(),
        ]);

        return view('reservations.my-reservations', compact('reservations'));
    }
}