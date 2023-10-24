<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ToursBookings extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Booking(): MorphOne
    {
        return $this->morphOne(Bookings::class, 'bookable_id', 'bookable_type');
    }
}
