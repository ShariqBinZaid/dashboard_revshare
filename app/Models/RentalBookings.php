<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalBookings extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Booking()
    {
        return $this->belongsTo(Bookings::class, 'booking_id', 'id');
    }

    public function Rental()
    {
        return $this->belongsTo(Rentals::class, 'rental_id', 'id');
    }
}
