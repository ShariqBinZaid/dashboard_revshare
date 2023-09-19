<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modules extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function permission()
    {
        return $this->hasMany(Permission::class, 'module_id', 'id')->orderBy('display_order');
    }
}
