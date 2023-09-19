<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function scopeIsUser($query, $id)
    {
        return $query->where('user_types.id', $id);
    }
}
