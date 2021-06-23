<?php

namespace App\Http\Controllers\Payment;

use \Spatie\WebhookClient\ProcessWebhookJob as SpatiaProcessWebhookJob;
use Illuminate\Support\Facades\Log;

use App\Models\Payment;
use App\Models\User;

class ProcessWebhookJob extends SpatiaProcessWebhookJob
{
    public function handle()
    {
        $payment = Payment::where('code', $this->webhookCall['payload']['event']['data']['code'])
                    ->where('transaction_id', $this->webhookCall['payload']['event']['data']['id'])
                    ->first();

        $charge_type = $this->webhookCall['payload']['event']['type'];
        //charge:created, charge:confirmed, charge:failed, charge:pending, charge:delayed
        switch($charge_type){
            case 'charge:pending':
                Log::info('charge:pending');
                $payment->state = 'charge:pending';
                $payment->save();
            break;

            case 'charge:confirmed':
                Log::info('charge:confirmed');
                $payment->state = 'charge:confirmed';
                $payment->save();
                $user = User::find($payment->customer_id);
                $user->wallet = ($user->wallet + $payment->local_amount);
                $user->save();
            break;

            case 'charge:failed':
                Log::info('charge:failed');
                $payment->state = 'charge:failed';
                $payment->save();
            break;

            case 'charge:delayed':
                Log::info('charge:delayed');
                $payment->state = 'charge:delayed';
                $payment->save();
                $user = User::find($payment->customer_id);
                $user->wallet = ($user->wallet + $payment->local_amount);
                $user->save();
            break;

            case 'charge:created':
                Log::info('charge:created');
                $payment->state = 'charge:created';
                $payment->save();
            break;
        }

    }
}
