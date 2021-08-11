<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Order;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function orders() {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }


    public function roleWithPermissions() {
        return $this->hasOne(Role::class, 'id', 'role_id')->with('permissions');
    }

    public function hasPermission($code) {
        if(!$this->roleWithPermissions) {
            return false;
        }

        foreach($this->roleWithPermissions()->permissions as $permission) {
            if($code === $permission->code) {
                return true;
            }
        }

        return false;
    }

    public function role() {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }
}
