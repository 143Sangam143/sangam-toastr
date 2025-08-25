<?php

namespace SangamToastr;

use Illuminate\Support\ServiceProvider;

class ToastrServiceProvider extends ServiceProvider
{
    public function boot(){
        $this->loadViewsFrom(__DIR__.'/../resources/views','sangam-toastr');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/sangam-toastr'),
        ],'views');

        $this->publishes([
            __DIR__.'./../resources/assets' => public_path('vendor/sangam-toastr'),
        ],'views');
    }

    public function register(){
        
    }
}