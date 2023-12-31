<?php

namespace App\Models;

use App\Models\Categories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rentals extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function RentalAddons()
    {
        return $this->hasMany(RentalAddons::class, 'rental_id', 'id');
    }

    public function Images()
    {
        return $this->hasMany(RentalImages::class, 'rental_id', 'id');
    }

    public function RentalImages()
    {
        return $this->hasMany(RentalImages::class, 'rental_id', 'id');
    }

    public function Categories()
    {
        return $this->hasMany(Categories::class, 'id', 'category_id');
    }

    public function getbooking()
    {
        return $this->hasMany(RentalBookings::class, 'rental_id', 'id');
    }
}
