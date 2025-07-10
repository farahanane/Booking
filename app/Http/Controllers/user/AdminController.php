<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationStatus; 

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->email !== 'admin@gmail.com') {
                return redirect()->route('listings.index')->with('error', 'Access denied. Only admin users can view the dashboard.');
            }
            return $next($request);
        });
    }

    public function dashboard(Request $request)
    {
        $search = $request->input('search');
        $locationCity = $request->input('location_city');

        $query = Listing::query();
        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('location_city', 'like', "%{$search}%");
        }
        if ($locationCity) {
            $query->where('location_city', $locationCity);
        }
        $listings = $query->paginate(6);

        if ($request->ajax()) {
            return response()->view('auth.dashboard-partial', compact('listings'))->header('Content-Type', 'text/html');
        }

        return view('auth.dashboard', compact('listings'));
    }

    public function reservations(Request $request)
    {
        $search = $request->input('search');
        $locationCity = $request->input('location_city');
        $checkInDate = $request->input('check_in_date');
        $checkOutDate = $request->input('check_out_date');

        $query = Auth::user()->email === 'admin@gmail.com'
            ? Reservation::with(['user', 'listing'])
            : Reservation::where('user_id', Auth::id())->with(['user', 'listing']);

        if ($search) {
            $query->whereHas('listing', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location_city', 'like', "%{$search}%");
            });
        }
        if ($locationCity) {
            $query->whereHas('listing', function ($q) use ($locationCity) {
                $q->where('location_city', $locationCity);
            });
        }
        if ($checkInDate) {
            $query->whereDate('start_date', $checkInDate);
        }
        if ($checkOutDate) {
            $query->whereDate('end_date', $checkOutDate);
        }

        // Default sort by check-in date (earliest to latest)
        $query->orderBy('start_date', 'asc');

        $reservations = $query->paginate(10);

        \Log::info('Reservations viewed', [
            'user_id' => Auth::id(),
            'is_admin' => Auth::user()->email === 'admin@gmail.com',
            'search' => $search,
            'location_city' => $locationCity,
            'check_in_date' => $checkInDate,
            'check_out_date' => $checkOutDate,
            'reservations_count' => $reservations->count(),
        ]);

        if ($request->ajax()) {
            return response()->view('auth.reservations-partial', compact('reservations'))->header('Content-Type', 'text/html');
        }

        return view('auth.reservations', compact('reservations'));
    }

    public function confirmReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->status = 'confirmed';
        $reservation->save();

        Mail::to($reservation->user->email)->send(new ReservationStatus($reservation, 'Confirmed'));

        return redirect()->back()->with('success', 'Reservation confirmed successfully.');
    }

    public function refuseReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->status = 'refused';
        $reservation->save();

        Mail::to($reservation->user->email)->send(new ReservationStatus($reservation, 'Refused'));

        return redirect()->back()->with('success', 'Reservation refused successfully.');
    }
   public function myReservations(Request $request)
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

    \Log::info('My Reservations viewed', [
        'user_id' => Auth::id(),
        'search' => $search,
        'check_in_date' => $checkInDate,
        'check_out_date' => $checkOutDate,
        'reservations_count' => $reservations->count(),
    ]);

    return view('my-reservations', compact('reservations'));
}
}