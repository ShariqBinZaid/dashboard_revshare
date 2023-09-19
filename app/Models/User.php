<?php



namespace App\Models;



use App\Models\Role;

use App\Models\UserRole;

use Laravel\Passport\HasApiTokens;

use Illuminate\Notifications\Notifiable;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;



class User extends Authenticatable

{

    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];


    protected $hidden = [
        'password',
        'remember_token',
    ];



    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userskill()
    {
        return $this->hasManyThrough(Skill::class, UserSkill::class, 'user_id', 'id');
    }


    public function role()
    {
        return $this->belongsToMany(
            Role::class,
            UserRole::class,
        );
    }
    public function skills()
    {
        return $this->belongsToMany(
            Skill::class,
            UserSkill::class,
        );
    }

    public function getpostview()
    {
        return $this->hasMany(PostView::class, 'viewed_by', 'id');
    }
    public function getpostlike()
    {
        return $this->hasMany(PostLike::class, 'user_id', 'id');
    }
    public function getpostcomment()
    {
        return $this->hasMany(PostComment::class, 'comment_by', 'id');
    }
    public function getcommentlikeUser()
    {
        return $this->hasMany(PostComment::class, 'comment_by', 'id');
    }
    public function getpayemtmethod()
    {
        return $this->hasMany(User::class, 'user_id', 'id');
    }
    public function getcompanyfellow()
    {
        return $this->hasManyThrough(Companies::class, CompanyFollowers::class, 'user_id', 'id');
    }
    public function hasPermission($name)
    {
        foreach ($this->role()->get() as $role) {

            $permissions = Permission::join('role_permissions', 'permissions.id', 'role_permissions.permission_id')
                ->where('role_permissions.role_id', $role->id)->get();

            foreach ($permissions as $permission) {
                if ($name == $permission->permission_name) {
                    return "true";
                }
            }
        }
        return "false";
    }

    public function isSuperUser()
    {
        return $this->user_type == 'super_admin';
    }

    public static function editRules($id)
    {
        return  [
            'id' => 'exists:users,id',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email|required|unique:users,email,' . $id,
        ];
    }

    public static function createRules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required',
            'email' => 'email|required|unique:users,email',
        ];
    }
}
