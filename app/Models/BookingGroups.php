<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingGroups extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Booking()
    {
        return $this->belongsTo(Bookings::class, 'booking_id', 'id');
    }
}
