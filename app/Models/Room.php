<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'listing_id',
        'room_type',
        'start_date',
        'end_date',
        'price',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}