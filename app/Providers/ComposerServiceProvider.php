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
                $view->with('notification_navbar',auth()->user()->notification()->select('id','text')->where('viewed',false)->orderBy('created_at','desc')->limit(5)->get());
                $view->with('notification_count',auth()->user()->notification()->where('viewed',false)->count());
            }else{
                $view->with('carts_navbar',collect([]));
                $view->with('cart_count',collect([]));
                $view->with('notification_navbar',collect([]));
                $view->with('notification_count',collect([]));
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
