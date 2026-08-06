<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Room;
use App\Models\Formula;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ListingController extends Controller
{
    public function createStep1()
    {
        return view('listings.create-step1');
    }

    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'hotel_category' => 'required|in:★★★☆☆,★★★★☆,★★★★★',
            'location_country' => 'required|string',
            'location_city' => 'required|string',
            'number_of_rooms' => 'required|integer|min:1',
            'images' => 'required|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'hotel_email' => 'required|email',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('listings_images', 'public');
            }
            $validated['image_url'] = json_encode($imagePaths);
        }

        $validated['user_id'] = auth()->id() ?? null;
        $listing = Listing::create($validated);

        return redirect()->route('listings.create-step2', $listing->id)->with('listing_id', $listing->id);
    }
    public function create()
      {
          return redirect()->route('listings.create-step1');
      }

    public function createStep2($id)
    {
        $listing = Listing::findOrFail($id);
        return view('listings.create-step2', compact('listing'));
    }

    public function storeStep2(Request $request, $id)
    {
        $listing = Listing::findOrFail($id);
        $validated = $request->validate([
            'rooms.*.room_type' => 'required|string|max:255',
            'rooms.*.start_date' => 'required|date',
            'rooms.*.end_date' => 'required|date|after:start_date',
            'rooms.*.price' => 'required|numeric|min:0',
        ]);

        foreach ($validated['rooms'] as $room) {
            Room::create([
                'listing_id' => $listing->id,
                'room_type' => $room['room_type'],
                'start_date' => $room['start_date'],
                'end_date' => $room['end_date'],
                'price' => $room['price'],
            ]);
        }

        return redirect()->route('listings.create-step3', $listing->id);
    }

    public function createStep3($id)
    {
        $listing = Listing::findOrFail($id);
        return view('listings.create-step3', compact('listing'));
    }

    public function storeStep3(Request $request, $id)
    {
        $listing = Listing::findOrFail($id);
        $validated = $request->validate([
            'formulas.*.formula_name' => 'required|string|max:255',
            'formulas.*.additional_price' => 'required|numeric|min:0',
        ]);

        foreach ($validated['formulas'] as $formula) {
            Formula::create([
                'listing_id' => $listing->id,
                'formula_name' => $formula['formula_name'],
                'additional_price' => $formula['additional_price'],
            ]);
        }

        return redirect()->route('auth.dashboard')->with('success', 'Listing, rooms, and formulas added successfully!');
    }

    public function index(Request $request)
{
    $query = Listing::query();

    // Location city filter
    if ($request->filled('location_city')) {
        $query->where('location_city', $request->location_city);
        \Log::info('Filtered by location_city: ' . $request->location_city);
    }

    $start_date = $request->filled('start_date') ? Carbon::parse($request->start_date) : null;
    $end_date = $request->filled('end_date') ? Carbon::parse($request->end_date) : null;
    $number_of_travelers = $request->filled('number_of_travelers') ? $request->number_of_travelers : null;

    // Debug: Log date and traveler parameters
    \Log::info('start_date: ' . ($start_date ? $start_date->toDateString() : 'null'));
    \Log::info('end_date: ' . ($end_date ? $end_date->toDateString() : 'null'));
    \Log::info('number_of_travelers: ' . $number_of_travelers);

    // Date and traveler filter
    if ($start_date && $end_date && $number_of_travelers) {
        $rooms_needed = ceil($number_of_travelers / 2);
        $query->whereHas('rooms', function ($q) use ($start_date, $end_date) {
            $q->where(function ($q) use ($start_date, $end_date) {
                $q->where('start_date', '<=', $end_date) // Room starts on or before end date
                   ->where('end_date', '>=', $start_date); // Room ends on or after start date
            });
        }, '>=', 1)->where('number_of_rooms', '>=', $rooms_needed);
        \Log::info('Filtered by rooms_needed: ' . $rooms_needed);
    }

    // Hotel category filter
    if ($request->filled('hotel_category')) {
        $query->where('hotel_category', $request->hotel_category);
        \Log::info('Filtered by hotel_category: ' . $request->hotel_category);
    }

    // Meal plan filter (using formulas table)
    if ($request->filled('meal_plan')) {
        $query->whereHas('formulas', function ($q) use ($request) {
            $q->where('formula_name', $request->meal_plan);
        });
        \Log::info('Filtered by meal_plan: ' . $request->meal_plan);
    }

    // Debug: Log the raw SQL query
    \Log::info('SQL Query: ' . $query->toSql());
    \Log::info('Bindings: ' . json_encode($query->getBindings()));

    $listings = $query->with(['rooms', 'formulas'])->paginate(9);

    // Debug: Log the number of listings found
    \Log::info('Number of listings found: ' . $listings->count());

    // Calculate minimum price for each listing based on available rooms
    $listings->getCollection()->transform(function ($listing) use ($start_date, $end_date) {
        if ($listing->rooms->isNotEmpty()) {
            $listing->min_price = $listing->rooms->min('price');
        } else {
            $listing->min_price = 0; // Default if no rooms match
        }
        return $listing;
    });

    return view('listings.index', compact('listings', 'start_date', 'end_date', 'number_of_travelers'));
}
    public function show(Request $request, $listing)
    {
        $listing = Listing::with(['rooms', 'formulas'])->findOrFail($listing);
        $start_date = $request->query('start_date') ? Carbon::parse($request->query('start_date')) : null;
        $end_date = $request->query('end_date') ? Carbon::parse($request->query('end_date')) : null;
        $number_of_travelers = $request->query('number_of_travelers') ?? null;

        return view('listings.show', compact('listing', 'start_date', 'end_date', 'number_of_travelers'));
    }

    public function edit($id)
    {
        $listing = Listing::findOrFail($id);
        return view('listings.edit', compact('listing'));
    }

    public function update(Request $request, $id)
    {
        $listing = Listing::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'hotel_category' => 'required|in:★★★☆☆,★★★★☆,★★★★★',
            'location_country' => 'required|string',
            'location_city' => 'required|string',
            'number_of_rooms' => 'required|integer|min:1',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'hotel_email' => 'required|email',
            'rooms.*.id' => 'nullable|exists:rooms,id',
            'rooms.*.room_type' => 'required|string|max:255',
            'rooms.*.start_date' => 'required|date',
            'rooms.*.end_date' => 'required|date|after:start_date',
            'rooms.*.price' => 'required|numeric|min:0',
            'formulas.*.id' => 'nullable|exists:formulas,id',
            'formulas.*.formula_name' => 'required|string|max:255',
            'formulas.*.additional_price' => 'required|numeric|min:0',
        ]);

        $imagePaths = json_decode($listing->image_url, true) ?: [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('listings_images', 'public');
            }
            $validated['image_url'] = json_encode($imagePaths);
        }

        $listing->update($validated);

        // Update or create rooms
        if (isset($validated['rooms'])) {
            foreach ($validated['rooms'] as $roomData) {
                if (isset($roomData['id'])) {
                    $room = Room::findOrFail($roomData['id']);
                    $room->update([
                        'room_type' => $roomData['room_type'],
                        'start_date' => $roomData['start_date'],
                        'end_date' => $roomData['end_date'],
                        'price' => $roomData['price'],
                    ]);
                } else {
                    Room::create([
                        'listing_id' => $listing->id,
                        'room_type' => $roomData['room_type'],
                        'start_date' => $roomData['start_date'],
                        'end_date' => $roomData['end_date'],
                        'price' => $roomData['price'],
                    ]);
                }
            }
        }

        // Update or create formulas
        if (isset($validated['formulas'])) {
            foreach ($validated['formulas'] as $formulaData) {
                if (isset($formulaData['id'])) {
                    $formula = Formula::findOrFail($formulaData['id']);
                    $formula->update([
                        'formula_name' => $formulaData['formula_name'],
                        'additional_price' => $formulaData['additional_price'],
                    ]);
                } else {
                    Formula::create([
                        'listing_id' => $listing->id,
                        'formula_name' => $formulaData['formula_name'],
                        'additional_price' => $formulaData['additional_price'],
                    ]);
                }
            }
        }

        return redirect()->route('auth.dashboard')->with('success', 'Listing, rooms, and formulas updated successfully!');
    }

    public function destroy($id)
    {
        $listing = Listing::findOrFail($id);
        $listing->delete();

        return redirect()->route('auth.dashboard');
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'location_city' => 'required|string',
            'start_date' => 'nullable|date|after_or_equal:today',
            'end_date' => 'nullable|date|after:start_date',
            'number_of_travelers' => 'nullable|integer|min:1',
            'hotel_category' => 'nullable|in:★★★☆☆,★★★★☆,★★★★★',
            'meal_plans' => 'nullable|string',
        ]);

        $location_city = $request->query('location_city');
        $start_date = $request->query('start_date') ? Carbon::parse($request->query('start_date')) : null;
        $end_date = $request->query('end_date') ? Carbon::parse($request->query('end_date')) : null;
        $number_of_travelers = $request->query('number_of_travelers');
        $hotel_category = $request->query('hotel_category');
        $meal_plans = $request->query('meal_plans');
        $rooms_needed = $number_of_travelers ? ceil($number_of_travelers / 2) : 1;

        $query = Listing::where('location_city', $location_city);

        if ($start_date && $end_date && $number_of_travelers) {
            $query->where('number_of_rooms', '>=', $rooms_needed)
                  ->whereDoesntHave('reservations', function ($q) use ($start_date, $end_date) {
                      $q->where(function ($q) use ($start_date, $end_date) {
                          $q->whereBetween('start_date', [$start_date, $end_date])
                            ->orWhereBetween('end_date', [$start_date, $end_date])
                            ->orWhere(function ($q) use ($start_date, $end_date) {
                                $q->where('start_date', '<=', $start_date)
                                  ->where('end_date', '>=', $end_date);
                            });
                      });
                  });
        }

        if ($hotel_category && $hotel_category !== '') {
            $query->where('hotel_category', $hotel_category);
        }

        if ($meal_plans && $meal_plans !== '') {
            $query->whereJsonContains('meal_plans', $meal_plans);
        }

        $listings = $query->paginate(9)->appends(request()->except('page')); // Preserve query parameters
        return view('listings.index', compact('listings', 'location_city', 'start_date', 'end_date', 'number_of_travelers', 'hotel_category', 'meal_plans'));
    }
}