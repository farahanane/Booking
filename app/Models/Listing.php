<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'hotel_category',
        'location_country',
        'location_city',
        'number_of_rooms',
        'hotel_email',
        'image_url',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function formulas()
    {
        return $this->hasMany(Formula::class);
    }
}