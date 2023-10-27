<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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

    public function bookable(): MorphTo
    {
        return $this->morphTo();
    }

    public function tour()
    {
        return $this->belongsTo(Tours::class, 'bookable_id', 'id');
    }

    public function rental()
    {
        return $this->belongsTo(Rentals::class, 'bookable_id', 'id');
    }

    public function upComming()
    {
        return $this->Tour()->whereDate('datetime', '>', Carbon::today(1));
    }

    public function availability()
    {
        return $this->belongsTo(RentalAvailability::class);
    }

    public function addons()
    {
        return $this->hasMany(BookingAddons::class, 'booking_id', 'id');
    }

    public function scopeBookingType(Builder $query, $type = 'default')
    {
        if ($type == 'rental') {
            $query->whereBookableType(Rentals::class);
        } elseif ($type == 'tour') {
            $query->whereBookableType(Tours::class);
        }
    }

    public function scopeListType(Builder $query, $type, $bookable = 'rental')
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        if ($bookable == 'rental') {
            if ($type == 'upcoming') {
                $query->where('datetime', '>', $now);
            } elseif ($type == 'past') {
                $query->where('datetime', '<', $now);
            }
        } elseif ($bookable == 'tour') {
            if ($type == 'upcoming') {
                $query->whereHas('tour', function($q) use($now){
                    $q->where('start_date', '>', $now);
                });
            } elseif ($type == 'past') {
                $query->whereHas('tour', function($q) use($now){
                    $q->where('start_date', '<', $now);
                });
            }
        }
    }
}
