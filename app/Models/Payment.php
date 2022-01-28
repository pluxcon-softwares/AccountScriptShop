<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['customer_id', 'customer_name', 'address', 'code', 'transaction_id',
                        'state', 'local_amount', 'local_currency', 'bitcoin_amount', 'bitcoin_currency'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
