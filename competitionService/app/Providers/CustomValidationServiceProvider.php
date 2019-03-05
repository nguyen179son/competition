<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
class CustomValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('greater', function($attribute, $value, $parameters, $validator) {
            $min_field = (int)str_replace("-","",$parameters[0]);
            $value = (int)str_replace("-","",$value);
            return $value >= $min_field;
        });

        Validator::replacer('greater', function($message, $attribute, $rule, $parameters) {
            return str_replace(':field', $parameters[0], $message);
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
