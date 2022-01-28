<?php

namespace App\Providers\View\Composer;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\Product;
use App\Models\User;

class AdminHomeProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('admin.partials.top_widgets', function($view){
            $data['products'] = Product::count();
            $data['users'] = User::count();
            $data['tickets'] = DB::table('tickets')->where('status', 0)->count();
            $data['payments'] = null;
            $payments = DB::table('coinpayment_transactions')->select('amount_total_fiat')
                                                                    ->where('status', '>=', 100)->get();
            foreach($payments as $payment)
            {
                $data['payments'] += $payment->amount_total_fiat;
            }
            $view->with('data', $data);
        });


        View::composer('admin.layouts.header', function($view){
            $countNotifications = Ticket::where('status', 0)->count();
            $notifications = Ticket::where('status', 0)->get();
            $view->with(['ticketNotifications' => $notifications, 'countUnresolvedTickets' => $countNotifications]);
        });

        View::composer('user.layouts.header', function($view){
            $ticketReplies = TicketReply::where('user_id', Auth::user()->id)->count();
            $view->with(['ticketReplies' => $ticketReplies]);
        });
    }
}
