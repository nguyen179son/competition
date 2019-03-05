<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
class ValidateLatitudeProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('latitude', function($attribute, $value, $parameters, $validator) {
            return is_numeric($value) && strpos($value,'.') && $value < 90.0 && $value > -90.0;
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
