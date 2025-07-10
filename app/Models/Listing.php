<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'hotel_category',
        'location_country',
        'location_city',
        'price_per_night',
        'number_of_rooms',
        'image_url',
        'hotel_email',
        'user_id',
    ];
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'listing_id');
    }

    
}