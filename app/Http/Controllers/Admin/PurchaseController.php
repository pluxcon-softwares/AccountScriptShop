<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $title = "All User Purchases";
        $purchases = Purchase::all();
        $totalPurchases = null;
        foreach($purchases as $purchase)
        {
            $totalPurchases .= $purchase->price;
        }
        return view('admin.purchases')->with(['title' => $title, 'totalPurchases' => $totalPurchases]);
    }

    public function allPurchases()
    {
        $purchases = DB::table('purchases')
                    ->select('purchases.*', 'sub_categories.sub_category_name AS type', 'users.username', 'users.email')
                    ->join('sub_categories', 'purchases.sub_category_id', '=', 'sub_categories.id')
                    ->join('users', 'purchases.user_id', '=', 'users.id')
                    ->get();

        return response()->json(['purchases' => $purchases]);
    }

    public function deletePurchase($id){
        $purchase = Purchase::find($id);

        $purchase->delete();

        return response()->json(['success' => 'Item Deleted!']);
    }
}
