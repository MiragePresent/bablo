<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
}
