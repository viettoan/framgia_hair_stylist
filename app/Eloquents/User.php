<?php

namespace App\Eloquents;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Eloquents\Relations\UserRelations;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, UserRelations;

    const PERMISSION_NOMAL = 0;
    const PERMISSION_ASSISTANT = 1;
    const PERMISSION_MAIN_WORKER = 2;
    const PERMISSION_ADMIN = 3;

    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';
    const GENDER_ORTHER = 'orther';

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
        'password',
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

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
