<?php

namespace App;

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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','session_key',
    ];

    public $timestamps = false;

    public function access_token() {
        return $this->hasOne('App\Models\Token\AccessToken');
    }

    public function alerts() {
        return $this->hasMany('App\Models\Alert');
    }

    public function collections() {
        return $this->hasMany('App\Models\Collection');
    }

    public function subscriptions() {
        return $this->hasMany('App\Models\Subscription');
    }
}
