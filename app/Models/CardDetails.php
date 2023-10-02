<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardDetails extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Payment()
    {
        return $this->belongsTo(Payments::class, 'payment_id', 'id');
    }
}
