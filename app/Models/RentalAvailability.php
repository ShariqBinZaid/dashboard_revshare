<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalAvailability extends Model
{
    use HasFactory;

    protected $table = 'rental_availability';
    protected $guarded = [];
}
