<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalImages extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Rental()
    {
        return $this->belongsTo(Rentals::class, 'rental_id', 'id');
    }
}
