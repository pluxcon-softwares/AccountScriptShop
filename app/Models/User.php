<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'wallet', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function cards()
    {
        return $this->hasMany('App\Models\Card');
    }

    public function messageBoards()
    {
        return $this->hasMany('App\Models\MessageBoard');
    }

    public function tickets()
    {
        return $this->hasMany('App\Models\Ticket');
    }

    public function ticketReply()
    {
        return $this->hasOne('App\Models\TicketReply');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }

    public function orderItems()
    {
        return $this->hasMany(['App\Models\OrderItem']);
    }

    public function purchases()
    {
        return $this->hasMany('App\Models\Purchase');
    }
}
