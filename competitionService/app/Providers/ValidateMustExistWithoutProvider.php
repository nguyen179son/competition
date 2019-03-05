<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
class ValidateMustExistWithoutProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('exist_without', function ($attribute, $value, $parameters, $validator) {
            return ((isset($value) && $value != null) && !(isset($parameters[0]) && $parameters[0] != null ))
                || (!(isset($value) && $value != null) &&  (isset($parameters[0]) && $parameters[0] != null));
        });

        Validator::replacer('exist_without', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':value', $parameters[0], $message);
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
