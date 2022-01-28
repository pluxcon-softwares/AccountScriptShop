<?php

namespace App\Http\Controllers\Admin;

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
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $title = 'All Ticket/Support';
        return view('admin.tickets')->with(['title' => $title]);
    }

    // Fetch All Tickets
    public function fetchAllTickets()
    {
        $tickets = Ticket::fetchAllTickets();
        return response()->json(['tickets' => $tickets]);
    }

    //Fetch ticket by id
    public function fetchTicketByID($id)
    {
        $ticket = Ticket::fetchTicketByID($id);
        return response()->json(['ticket' => $ticket]);
    }

    // Store ticket reply
    public function storeReply(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reply'     =>  'required'
        ]);
        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()]);
        }
        $reply = new TicketReply();
        $reply->ticket_id = $request->ticket_id;
        $reply->user_id = $request->user_id;
        $reply->reply = $request->reply;
        $reply->save();

        $updateTicketStatus = Ticket::find($request->ticket_id);
        $updateTicketStatus->status = 1;
        $updateTicketStatus->save();

        return response()->json(['success' => 'Reply sent successfully!']);
    }

    public function deleteTicket($id){
        $ticket = Ticket::find($id);
        $ticket->delete();
        return response()->json(['status' => 200]);
    }
}
