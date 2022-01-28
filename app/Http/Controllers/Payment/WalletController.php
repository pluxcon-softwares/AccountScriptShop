<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
//use App\Http\Controllers\Payment\CoinbaseGateway;
use Hexters\CoinPayment\CoinPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Payment;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Cart;

class WalletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addMoney()
    {
        $title = 'Add Money';
        //$payment_history = Payment::where('customer_id', Auth::user()->id)->get();
        $payment_history = DB::table('coinpayment_transactions')
                            ->where('buyer_email', Auth::user()->email)
                            ->get();
        return view('user.add-money')->with(['title' => $title, 'payment_history' => $payment_history]);
    }

    public function deposit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'deposit' => 'required'
        ]);
        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }

        $transaction['order_id'] = uniqid(); //invoice number
        $transaction['amountTotal'] = (FLOAT) $request->deposit;
        $transaction['note'] = config('app.name') . ' ' . 'wallet funding';
        $transaction['buyer_name']  = Auth::user()->username;
        $transaction['buyer_email'] = Auth::user()->email;
        $transaction['redirect_url'] = route('deposit.complete');
        $transaction['cancel_url'] = route('deposit.cancel');

        $transaction['items'][] = [
            'itemDescription'   =>  'Funding Wallet',
            'itemPrice'     =>  (FLOAT) $request->deposit,
            'itemQty'   =>  (INT) 1,
            'itemSubtotalAmount'    =>  (FLOAT) $request->deposit
        ];

        $payment_link = CoinPayment::generatelink($transaction);

        return redirect($payment_link);

        /*$createCharge = new CoinbaseGateway;
        $storeCharge = $createCharge->createCharges([
            "name" => "Skull-Net Wallet Depositor",
            "description" => 'SkullNet Funding Wallet',
            "pricing_type" => "fixed_price",
            "local_price" => [
                "amount" => $request->deposit,
                "currency" => "USD",
            ],
            "metadata" => [
                "customer_id" => Auth::user()->id,
                "customer_name" => Auth::user()->email
            ],
            "redirect_url" => route('deposit.complete'),
            "cancel_url" => route('deposit.cancel')
        ]);

        $payment = new Payment;
        $payment->customer_id = intval($storeCharge['data']['metadata']['customer_id']);
        $payment->customer_name = $storeCharge['data']['metadata']['customer_name'];
        $payment->address = $storeCharge['data']['addresses']['bitcoin'];
        $payment->code = $storeCharge['data']['code'];
        $payment->transaction_id = $storeCharge['data']['id'];
        $payment->local_amount = floatval($storeCharge['data']['pricing']['local']['amount']);
        $payment->local_currency = $storeCharge['data']['pricing']['local']['currency'];
        $payment->bitcoin_amount = floatval($storeCharge['data']['pricing']['bitcoin']['amount']);
        $payment->bitcoin_currency = $storeCharge['data']['pricing']['bitcoin']['currency'];
        $payment->save();

        return redirect($storeCharge['data']['hosted_url']);*/

    }

    public function depositComplete()
    {
        $title = "Deposit Completed";
        return view('user.deposit-completed', compact('title'));
    }

    public function depositCancel()
    {
        $title = "Deposit Canceled";
        return view('user.deposit-canceled', compact('title'));
    }

    public function cartPage()
    {
        $title = "Order Items";
        /*$orderItems = DB::table('order_items')
                        ->select('order_items.id', 'sub_categories.sub_category_name AS product_type',
                        'products.name','products.price')
                        ->join('products', 'order_items.product_id', '=', 'products.id')
                        ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
                        ->join('users', 'order_items.user_id', '=', 'users.id')
                        ->where('users.id', '=', Auth::user()->id)
                        ->get();*/
                        $cart_items = DB::table('carts')
                        ->select('carts.id','products.name', 'products.price', 'sub_categories.sub_category_name AS product_type')
                        ->join('products', 'carts.product_id', '=', 'products.id')
                        ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
                        ->join('users', 'carts.user_id', '=', 'users.id')
                        ->where('users.id', '=', Auth::user()->id)
                        ->get();
        $totalPrice = null;
        foreach($cart_items as $item)
        {
            $totalPrice += $item->price;
        }
        return view('user.cart')->with([
            'title' => $title,
            'cartItems' => $cart_items,
            'totalPrice' => $totalPrice
            ]);
    }

    public function checkCart()
    {
        $cart = Cart::where('user_id', Auth::user()->id)->count();
        if($cart == 0)
        {
            return response()->json(['empty_cart' => true]);
        }
    }

    public function addToCart(Request $request)
    {
        $wallet = Auth::user()->wallet;

        $product_id = $request->id;

        if($wallet == 0.00)
        {
            return response()->json(['wallet' => "Your balance is: $0.00, fund your wallet"]);
        }

        $product = Product::select('id', 'price')
                        ->where('id', $product_id)
                        ->first();

        //return response()->json(['success' => $product]);

        if($product->price > $wallet)
        {
            return response()->json(['wallet' => "You don't have enough in your wallet to purchase this product"]);
        }

        if(Cart::where('product_id', $product_id)->first())
        {
            return response()->json(['errors' => 'Item already in cart']);
        }

        $cart = new Cart();
        $cart->user_id = Auth::user()->id;
        $cart->product_id = $product_id;
        $cart->price = $product->price;
        $cart->save();

        return response()->json(['success' => "Item Added to Cart"]);
    }

    public function countCartItems()
    {
        $countCartItems = Cart::where('user_id', '=', Auth::user()->id)->count();
        return response()->json(['countCartItems' => $countCartItems]);
    }

    public function deleteCartItem($id)
    {
        $countItemsInCart = Cart::where('user_id', Auth::user()->id)->count();

        $orderItem = Cart::where('id', '=', $id)
                        ->where('user_id', '=', Auth::user()->id)
                        ->first();

        if($countItemsInCart == 0)
        {
            return response()->json(['status' => true]);
        }else{
            $orderItem->delete();
            return response()->json(['status' => 200]);
        }

    }

    public function processOrder()
    {

        $cart = Cart::where('user_id', Auth::user()->id)->get();

        if(count($cart) <= 0)
        {
            return response()->json(['empty_cart' =>  "You dont have item(s) in cart"]);
        }

        $totalOrderAmount = null;

        foreach($cart as $item)
        {
            $totalOrderAmount += $item->price;
        }

        foreach($cart as $item)
        {
                $product = Product::find($item->product_id);
                $purchase = new Purchase();
                $purchase->user_id = $item->user_id;
                $purchase->sub_category_id = $product->sub_category_id;
                $purchase->order_id = $this->randomStringGenerator();
                $purchase->name = $product->name;
                $purchase->description = $product->description;
                $purchase->price = $product->price;
                $purchase->save();
                $product->delete();
        }

        $user = User::find(Auth::user()->id);
        $user->wallet -= $totalOrderAmount;
        $user->save();
        Cart::where('user_id', Auth::user()->id)->delete();
        return response()->json(['success' => 'Purchase Complate - Thank you!', 'price' => $totalOrderAmount]);
    }

    public function thankYou()
    {
        $title = "Purchase Complete, Thank You!";
        return view('user.thank-you', compact('title'));
    }


    //************** RANDOM STRING GENERATOR ************* */
    protected function randomStringGenerator($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomStr = '';
        for($i = 0; $i < $length; $i++)
        {
            $randomStr .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomStr;
    }

}
