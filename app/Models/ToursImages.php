<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToursImages extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Tour()
    {
        return $this->belongsTo(Tours::class, 'tour_id', 'id');
    }
}
