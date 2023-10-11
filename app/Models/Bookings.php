<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function Tour()
    {
        return $this->belongsTo(ToursBookings::class, 'booking_id', 'id');
    }
    public function Rental()
    {
        return $this->belongsTo(RentalBookings::class, 'booking_id', 'id');
    }
}
