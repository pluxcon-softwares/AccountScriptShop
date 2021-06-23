<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Card;

class CardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = 'All Credit Cards';
        $cards = Card::all();
        return view('user.cards')->with(['title' => $title, 'cards' => $cards]);
    }
}
