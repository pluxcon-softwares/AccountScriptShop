<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['username', 'email', 'password', 'access'];

    protected $guard = 'admin';

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function messageBoard()
    {
        return $this->hasMany('App\Models\MessageBoard');
    }

    public function cards()
    {
        return $this->hasMany('App\Models\Card');
    }
}
