<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageBoard extends Model
{
    protected $fillable = ['title', 'body', 'is_published', 'admin_id'];

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin');
    }
}
