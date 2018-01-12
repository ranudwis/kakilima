<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        View::composer('*',function($view){
            if(auth()->check()){
                $view->with('carts_navbar',auth()->user()->cart()->limit(4)->get());
                $view->with('cart_count',auth()->user()->cart->count());
            }else{
                $view->with('carts_navbar',collect([]));
                $view->with('cart_count',collect([]));
            }
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
