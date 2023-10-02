<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToursBookings extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Booking()
    {
        return $this->belongsTo(Bookings::class, 'booking_id', 'id');
    }

    public function Tour()
    {
        return $this->belongsTo(Tours::class, 'tour_id', 'id');
    }
}
