<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['admin_id', 'card_type', 'card_number', 'bin', 'exp','holder', 'country',
    'address', 'state', 'city', 'dob', 'ssn', 'zip', 'base', 'price'];

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin');
    }
}
