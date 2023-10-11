<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return $this->belongsTo(ToursBookings::class, 'id', 'booking_id');
    }

    public function Rental()
    {
        return $this->belongsTo(RentalBookings::class, 'booking_id', 'id');
    }

    public function upComming() {
        return $this->Tour()->whereDate('datetime','>', Carbon::today(1));
    }
}
