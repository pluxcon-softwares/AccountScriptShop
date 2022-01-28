<?php

namespace App\Providers\View\Composer;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class UserHomeProvider extends ServiceProvider
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
        View::composer('user.layouts.header', function($view){
            $data['categories'] = Category::all()->toArray();
            $view->with(['data' => $data]);
        });

        View::composer('*', function($view){
            $settings = Setting::first();
            $view->with(['settings' => $settings]);
        });

        
    }
}
