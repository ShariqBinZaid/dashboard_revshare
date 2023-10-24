<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Bookings extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function bookableType(): MorphTo
    {
        return $this->morphTo();
    }

    public function Tour()
    {
        return $this->morphOne(ToursBookings::class, 'bookable_id', 'bookable_type');
    }

    public function Rental()
    {
        return $this->morphOne(RentalBookings::class, 'bookable_id', 'bookable_type');
    }

    public function upComming()
    {
        return $this->Tour()->whereDate('datetime', '>', Carbon::today(1));
    }

    public function availability()
    {
        return $this->belongsTo(RentalAvailability::class);
    }
}
