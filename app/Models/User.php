<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

/**
 *  Model User
 * @property int $id
 * @property string $login
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property float  $balance
 *
 * @property-read \App\Models\Check[]|\Illuminate\Database\Eloquent\Collection $checks
 */

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

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


    public function checks()
    {
        return $this->hasMany(\Check::class);
    }

    public function getNameAttribute()
    {
        return !($this->first_name && $this->last_name) ? $this->login : $this->first_name. ' ' . $this->last_name;
    }
}
