<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalReviews extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function Rental()
    {
        return $this->belongsTo(Rentals::class, 'rental_id', 'id');
    }
}
