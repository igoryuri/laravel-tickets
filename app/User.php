<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const ACCESS_LEVEL = [
        1 => 'Nível 1',
        2 => 'Nível 2',
        3 => 'Nível 3',
        4 => 'Nível 4',
        5 => 'Nível 5',
        6 => 'Nível 6',
        7 => 'Nível 7',
        8 => 'Nível 8',
        9 => 'Nível 9',
        10 => 'Nível 10'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'groups', 'email', 'password', 'access_level', 'department_id'
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
