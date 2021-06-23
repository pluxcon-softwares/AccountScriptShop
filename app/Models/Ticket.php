<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ticket extends Model
{
    protected $fillable = ['user_id', 'subject', 'message', 'status'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function ticketReply()
    {
        return $this->hasOne('App\Models\TicketReply');
    }

    public static function fetchAllTickets()
    {
        $tickets = DB::table('tickets')
                    ->select('tickets.id', 'tickets.subject', 'tickets.user_id', 'tickets.status','users.username', 'users.email')
                    ->join('users', 'tickets.user_id', '=', 'users.id')
                    ->orderBy('tickets.id', 'DESC')
                    ->get();
        return $tickets;
    }

    public static function fetchTicketByID($id)
    {
        $ticket = DB::table('tickets')
                        ->select('tickets.id','tickets.user_id','tickets.subject','tickets.message',
                        'tickets.status', 'users.username', 'users.email')
                        ->join('users', 'tickets.user_id', '=', 'users.id')
                        ->where('tickets.id', '=', $id)
                        ->first();
        return $ticket;
    }
}
