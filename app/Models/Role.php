<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;
use App\Models\RolePermission;



class Role extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function permission()
    {
        return $this->hasManyThrough(
            Permission::class,
            RolePermission::class,
            'role_id',
            'id'
        );
    }
    public function user()
    {
        return $this->belongsToMany(
            User::class,
            UserRole::class
        );
    }

    public function userskill()
    {
        return $this->hasManyThrough(Skill::class, UserSkill::class, 'user_id', 'id');
    }

    public function role_permission()
    {
        return $this->hasMany(RolePermission::class, 'role_id', 'id');
    }

    public function countUser()
    {
        return $this->hasMany(UserRole::class, 'role_id', 'id');
    }
}
