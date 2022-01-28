<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketReply extends Model
{
    protected $fillable = ['reply', 'ticket_id', 'user_id'];

    public function ticket()
    {
        return $this->belongsTo('App\Models\Ticket');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
