<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['user_id', 'site_name', 'site_logo', 'page_background'];
}
