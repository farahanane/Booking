<?php
// app/Models/Listing.php
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
        'meal_plans',
    ];

   
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'listing_id');
    }

    public function plans()
    {
        return $this->hasMany(Plan::class, 'listing_id');
    }
}