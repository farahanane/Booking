<?php
namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::where('user_id', auth()->id())->with('listing')->get();
        return view('listings.index', compact('reservations'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'listing_id' => 'required|exists:listings,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'number_of_travelers' => 'required|integer|min:1|max:10',
                'room_type' => 'required|exists:plan,id',
                'meal_plan' => 'nullable|string',
                'total_price' => 'required|numeric|min:0',
            ]);

            $listing = Listing::findOrFail($request->listing_id);

            $reservation = Reservation::create([
                'listing_id' => $request->listing_id,
                'user_id' => auth()->id(),
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'number_of_travelers' => $request->number_of_travelers,
                'room_type' => $request->room_type,
                'meal_plan' => $request->meal_plan,
                'total_price' => $request->total_price,
                'status' => 'pending',
            ]);

            $debug = [
                'start_date' => $reservation->start_date,
                'end_date' => $reservation->end_date,
                'is_string_start' => is_string($reservation->start_date),
                'is_carbon_start' => $reservation->start_date instanceof Carbon,
                'reservation_id' => $reservation->id,
            ];
            Log::info('Reservation created:', $debug);

            // Set a success message in the session
            return redirect()->route('listings.index')->with('success', 'Your reservation was created successfully!');
        } catch (\Exception $e) {
            Log::error('Reservation creation failed: ' . $e->getMessage());
            dd('Error: ' . $e->getMessage());
        }
    }
}