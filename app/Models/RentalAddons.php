<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalAddons extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Rental()
    {
        return $this->belongsTo(User::class, 'rental_id', 'id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
