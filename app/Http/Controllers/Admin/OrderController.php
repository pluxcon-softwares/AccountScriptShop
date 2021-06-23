<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Payment;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $title = "All Orders";
        return view('admin.orders')->with(['title' => $title]);
    }

    public function getAllOrders()
    {
        $orders = DB::table('payments')
                            ->select('payments.id', 'payments.local_amount', 'payments.state', 'users.username',
                            'payments.bitcoin_amount', 'payments.code')
                            ->join('users', 'payments.customer_id', '=', 'users.id')
                            ->get();

        return response()->json(['orders' => $orders]);
    }

    public function getOrderProfit()
    {
        $orders = DB::table('payments')
                    ->select('payments.local_amount')
                    ->where('payments.state', '=', 'charge:confirmed')
                    ->get();

        $profits = null;
        foreach($orders as $order){
            $profits = ($profits + $order->local_amount);
        }

        return response()->json(['profits' => $profits]);
    }
}
