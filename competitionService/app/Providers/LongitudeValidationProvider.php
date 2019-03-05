<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
class LongitudeValidationProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('longitude', function($attribute, $value, $parameters, $validator) {
            return is_numeric($value) && strpos($value,'.') && $value < 180.0 && $value > -180.0;
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
