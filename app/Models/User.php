<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login',
        'email',
        'first_name',
        'last_name',
        'password',
        'balance'
    ];

    protected $appends = [
        'name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    public function getNameAttribute()
    {
        return !($this->first_name && $this->last_name) ? $this->login : $this->first_name. ' ' . $this->last_name;
    }
}
