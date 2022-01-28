<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MessageBoard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class MessageBoardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $title = "All Messages";

        return view('admin.message-board', compact('title'));
    }

    public function allMessages()
    {
        $messages = MessageBoard::all();
        return response()->json(['data' => $messages]);
    }

    public function viewMessage($id)
    {
        $message = MessageBoard::find($id);

        return response()->json(['data' => $message]);
    }

    public function createMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'addTitle' =>  'required|max:200',
            'addBody'  =>  'required'
        ]);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()]);
        }

        $message = new MessageBoard;
        $message->title = $request->addTitle;
        $message->body = $request->addBody;
        $message->is_published = $request->addPublished;
        $message->admin_id = Auth::user()->id;
        $message->save();

        return response()->json(['success' => 'Your message has been created!']);
    }

    public function editMessage($id)
    {
        $message = MessageBoard::find($id);

        return response()->json(['data' => $message]);
    }

    public function updateMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'editTitle' =>  'required',
            'editBody'  =>      'required'
        ]);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()]);
        }

        $message = MessageBoard::find($request->message_id);
        $message->title = $request->editTitle;
        $message->body = $request->editBody;
        $message->is_published = $request->editPublished;
        $message->save();

        return response()->json(['success' => "Message has been updated!"]);
    }

    public function deleteMessage($id)
    {
        $message = MessageBoard::find($id);
        $message->delete();

        return response()->json(['success' => "Message was deleted successfully!"]);
    }
}
