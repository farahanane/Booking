<?php
namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Plan;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ListingController extends Controller
{
    public function index(Request $request)
{
    $query = Listing::query();

    // Apply search filters
    if ($request->has('location_city') && $request->location_city) {
        $query->where('location_city', $request->location_city);
    }

    // Date and traveler filters
    if ($request->has('start_date') && $request->has('end_date') && $request->has('number_of_travelers')) {
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $number_of_travelers = $request->number_of_travelers;
        $rooms_needed = ceil($number_of_travelers / 2);

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

    // Hotel category filter
    if ($request->has('hotel_category') && $request->hotel_category) {
        $query->where('hotel_category', $request->hotel_category);
    }

    // Meal plan filter - exact match with the full string including price
    if ($request->has('meal_plan') && $request->meal_plan) {
        $query->whereJsonContains('meal_plans', $request->meal_plan);
    }

    $listings = $query->with(['plans' => function($query) {
        $query->select('listing_id', \DB::raw('MIN(base_price) as min_price'))
              ->groupBy('listing_id');
    }])->paginate(9);

    return view('listings.index', compact('listings'));
}
    public function create()
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
            'user_id' => 'nullable|exists:users,id',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('listings_images', 'public');
            }
            $validated['image_url'] = json_encode($imagePaths);
        } else {
            $validated['image_url'] = json_encode([]);
        }

        $validated['user_id'] = $validated['user_id'] ?? auth()->id() ?? null;
        $validated['meal_plans'] = json_encode([]); // Initialize empty meal plans

        $listing = Listing::create($validated);

        return redirect()->route('listings.create-step2', $listing->id)->with('listing_id', $listing->id);
    }

    public function createStep2($id)
    {
        $listing = Listing::findOrFail($id);
        return view('listings.create-step2', compact('listing'));
    }

    public function storeStep2(Request $request, $id)
    {
        $listing = Listing::findOrFail($id);
        \Log::info('Request data: ', $request->all());
        $validated = $request->validate([
            'room_types.*.name' => 'required|string|max:255',
            'room_types.*.price' => 'required|numeric|min:0',
            'meal_plans' => 'nullable|array',
            'meal_plans.*' => 'string',
        ]);

        foreach ($validated['room_types'] as $room) {
            \DB::table('plan')->insert([
                'listing_id' => $listing->id,
                'room_type' => $room['name'],
                'base_price' => $room['price'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $mealPlans = $validated['meal_plans'] ?? [];
        \Log::info('Meal plans to save: ', ['meal_plans' => $mealPlans]);
        $listing->update(['meal_plans' => json_encode($mealPlans)]);
        \Log::info('Updated listing meal_plans: ', ['meal_plans' => $listing->meal_plans]);

        return redirect()->route('auth.dashboard')->with('success', 'Listing and details added successfully!');
    }

    public function show($id, Request $request)
    {
        $listing = Listing::with('plans')->findOrFail($id);
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');
        $number_of_travelers = $request->query('number_of_travelers');

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
        ]);

        $imagePaths = json_decode($listing->image_url, true) ?: [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('listings_images', 'public');
            }
            $validated['image_url'] = json_encode($imagePaths);
        }

        $listing->update($validated);

        return redirect()->route('auth.dashboard');
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