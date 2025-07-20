<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plan'; 
    protected $fillable = ['listing_id', 'room_type', 'plan', 'base_price'];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}