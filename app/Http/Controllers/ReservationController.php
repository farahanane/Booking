<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::query();

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('listing', function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('location_city', 'like', "%$search%");
            });
            Log::info('Filtered by search: ' . $search);
        }

        if ($request->filled('location_city')) {
            $query->whereHas('listing', function ($q) use ($request) {
                $q->where('location_city', $request->location_city);
            });
            Log::info('Filtered by location_city: ' . $request->location_city);
        }

        $checkInDate = $request->filled('check_in_date') ? $request->input('check_in_date') : null;
        $checkOutDate = $request->filled('check_out_date') ? $request->input('check_out_date') : null;

        if ($checkInDate && $checkOutDate) {
            $query->where(function ($q) use ($checkInDate, $checkOutDate) {
                $q->whereBetween('start_date', [$checkInDate, $checkOutDate])
                  ->orWhereBetween('end_date', [$checkInDate, $checkOutDate])
                  ->orWhere(function ($q) use ($checkInDate, $checkOutDate) {
                      $q->where('start_date', '<=', $checkInDate)
                        ->where('end_date', '>=', $checkOutDate);
                  });
            });
            Log::info('Filtered by date range: ' . $checkInDate . ' to ' . $checkOutDate);
        }

        // Filter by user for non-admin, or all reservations for admin
        if (Auth::user()->email !== 'admin@gmail.com') {
            $query->where('user_id', Auth::id());
        }

        $reservations = $query->with(['listing', 'room'])->paginate(10);

        Log::info('Number of reservations found: ' . $reservations->count());

        return view('auth.reservations', compact('reservations', 'checkInDate', 'checkOutDate'));
    }

    public function store(Request $request)
    {
        Log::info('Form Data: ', $request->all());

        $validated = $request->validate([
            'listing_id' => 'required|exists:listings,id',
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'number_of_travelers' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'meal_plan' => 'nullable|string',
        ]);

        $listingId = $request->input('listing_id');
        $roomId = $request->input('room_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        Log::info('Validated Data: ', $validated);
        Log::info('Room ID: ' . $roomId);

        // Check if the room exists for this listing
        $room = Room::where('id', $roomId)->where('listing_id', $listingId)->first();
        if (!$room) {
            Log::error('Room not found', ['room_id' => $roomId, 'listing_id' => $listingId]);
            return redirect()->back()->withErrors(['room_id' => 'The selected room is invalid.'])->withInput();
        }

        // Check date availability
        $conflictingReservation = Reservation::where('room_id', $roomId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                      ->orWhereBetween('end_date', [$startDate, $endDate])
                      ->orWhere(function ($query) use ($startDate, $endDate) {
                          $query->where('start_date', '<=', $startDate)
                                ->where('end_date', '>=', $endDate);
                      });
            })->exists();

        if ($conflictingReservation) {
            Log::warning('Conflicting reservation found', ['room_id' => $roomId, 'start_date' => $startDate, 'end_date' => $endDate]);
            return redirect()->back()->with('error', 'The room is already reserved for the selected dates.')->withInput();
        }

        // Check if dates are within room availability
        if ($startDate < $room->start_date || $endDate > $room->end_date) {
            Log::warning('Dates outside availability', ['start_date' => $startDate, 'end_date' => $endDate, 'room_dates' => [$room->start_date, $room->end_date]]);
            return redirect()->back()->with('error', 'The selected dates are outside the room availability period.')->withInput();
        }

        $data = [
            'user_id' => Auth::id(),
            'listing_id' => $listingId,
            'room_id' => $roomId,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'number_of_travelers' => $validated['number_of_travelers'],
            'total_price' => $validated['total_price'],
            'meal_plan' => $validated['meal_plan'],
        ];
        Log::info('Data to create: ', $data);

        try {
            $reservation = Reservation::create($data);
            Log::info('Reservation created', ['id' => $reservation->id]);
        } catch (\Exception $e) {
            Log::error('Failed to create reservation', ['error' => $e->getMessage(), 'data' => $validated]);
            return redirect()->back()->with('error', 'Failed to create reservation. Please try again.')->withInput();
        }

        return redirect()->route('auth.reservations')->with('success', 'Reservation created successfully!');
    }
}