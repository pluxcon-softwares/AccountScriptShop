<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        //Status is >= 100 for transaction completion
        $data['transaction_completed'] = DB::table('coinpayment_transactions')
                                    ->select('id', 'buyer_email', 'amount_total_fiat', 
                                    'status', 'created_at', 
                                    'buyer_name', 'status_text', 'order_id')
                                    ->where('status', '>=', 100)
                                    ->get();
        
        $data['transaction_pending'] = DB::table('coinpayment_transactions')
                                    ->select('id', 'buyer_email', 'amount_total_fiat', 
                                    'status', 'created_at', 
                                    'buyer_name', 'status_text', 'order_id')
                                    ->where('status', '=', 0)
                                    ->get();
        

        $data['transaction_failed'] = DB::table('coinpayment_transactions')
                                    ->select('id', 'buyer_email', 'amount_total_fiat', 
                                    'status', 'created_at', 
                                    'buyer_name', 'status_text', 'order_id')
                                    ->where('status', '<', 0)
                                    ->get();

        $data['title'] = 'Admin Dashboard';
        return view('admin.dashboard')->with(['data' => $data]);
    }
}
