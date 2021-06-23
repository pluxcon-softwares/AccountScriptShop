<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = "My Purchases";
        return view('user.purchase', compact('title'));
    }

    public function getPurchasesByUser()
    {
        $purchases = DB::table('purchases')
                    ->select('sub_categories.sub_category_name AS type', 'purchases.id', 'purchases.order_id', 'purchases.name', 'purchases.price', 'purchases.created_at')
                    ->join('sub_categories', 'purchases.sub_category_id', '=', 'sub_categories.id')
                    ->join('users', 'purchases.user_id', '=', 'users.id')
                    ->where('purchases.user_id', '=', Auth::user()->id)
                    ->get();

        return response()->json(['purchases' => $purchases]);
    }

    public function getPurchaseDetailsByUser($id)
    {
        $purchase = DB::table('purchases')
                    ->select('sub_categories.sub_category_name AS type', 'purchases.id', 'purchases.order_id', 'purchases.name', 'purchases.description', 'purchases.price', 'purchases.created_at')
                    ->join('sub_categories', 'purchases.sub_category_id', '=', 'sub_categories.id')
                    ->join('users', 'purchases.user_id', '=', 'users.id')
                    ->where('purchases.id', '=', $id)
                    ->where('purchases.user_id', '=', Auth::user()->id)
                    ->first();

        return response()->json(['purchase' => $purchase]);
    }

    public function deletePurchaseByUser($id)
    {
        $purchase = Purchase::where('id', $id)
                            ->where('user_id', Auth::user()->id)
                            ->first();

        $purchase->delete();

        return response()->json(['success' => 'Item Deleted!']);
    }
}
