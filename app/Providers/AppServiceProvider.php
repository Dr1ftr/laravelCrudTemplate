<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Schema; // https://www.codegrepper.com/code-examples/php/laravel+8+Syntax+error+or+access+violation%3A+1071+Specified+key+was+too+long%3B+max+key+length+is+1000+bytes

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultstringLength(191);
    }
}
