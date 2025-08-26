<?php

namespace SangamToastr;

use Illuminate\Support\ServiceProvider;

class ToastrServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'sangam-toastr');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/sangam-toastr'),
            ], 'sangam-toastr-views');

            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/sangam-toastr'),
            ], 'sangam-toastr-assets');

            // Publish both with a single tag
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/sangam-toastr'),
                __DIR__.'/../resources/assets' => public_path('vendor/sangam-toastr'),
            ], 'sangam-toastr');
        }
    }

    /**
     * Register any package services.
     */
    public function register(): void
    {
        //
    }
}