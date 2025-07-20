<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservation extends Model
{
    protected $fillable = [
        'listing_id',
        'user_id',
        'start_date',
        'end_date',
        'number_of_travelers',
        'room_type',
        'meal_plan',
        'total_price',
        'status',
    ];

    protected $dates = ['start_date', 'end_date', 'created_at', 'updated_at']; // Cast to Carbon

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ]; // Explicit casting as a fallback

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}