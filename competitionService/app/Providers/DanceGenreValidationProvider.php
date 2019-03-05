<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
class DanceGenreValidationProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('danceGenre', function($attribute, $value, $parameters, $validator) {
            return in_array($value,config('dance_genres'));
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
