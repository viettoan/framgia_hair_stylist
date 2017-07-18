<?php

namespace App\Eloquents;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Eloquents\Relations\UserRelations;

class User extends Authenticatable
{
    use Notifiable, UserRelations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'birthday',
        'avatar',
        'gender',
        'permission',
        'experience',
        'specialize',
        'about_me',
        'department_id',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
