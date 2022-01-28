<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = 'All Ticket';
        $tickets = Ticket::where('user_id', Auth::user()->id)->get();
        return view('user.tickets')->with(['title' => $title, 'tickets' => $tickets]);
    }

    public function openTicket(Request $request)
    {
        /*$request->validate([
            'subject' => 'required|max:120',
            'message' => 'required|max:3000'
        ]);*/
        $validator = Validator::make($request->all(), [
            'subject' =>    'required|max:250',
            'message' =>    'required|max:3000'
        ]);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()]);
        }

        $ticket = new Ticket;
        $ticket->user_id = Auth::user()->id;
        $ticket->subject = $request->subject;
        $ticket->message = $request->message;
        $ticket->save();

        return response()->json(['status' => 200]);
    }

    public function viewTicketReply($ticket_id)
    {
        $replies = TicketReply::select('ticket_replies.reply', 'users.username','ticket_replies.created_at')
                                ->join('tickets', 'tickets.id', '=', 'ticket_replies.ticket_id')
                                ->join('users', 'users.id', '=', 'ticket_replies.user_id')
                                ->where('ticket_replies.ticket_id', '=', $ticket_id)
                                ->orderBy('ticket_replies.id','DESC')
                                ->get();
        return response()->json(['replies' => $replies]);
    }

    public function deleteTicket($ticket_id)
    {
        $ticket = Ticket::where('id', $ticket_id)
                            ->where('user_id', Auth::user()->id)
                            ->first();

        $ticket->delete();

        return response()->json(['success' => 'Ticket Deleted!']);
    }
}
