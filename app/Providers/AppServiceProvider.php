<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Blade::directive('money', function ($price) {
            $result = [];
            $length = strlen($price);
            $tmpPrice = $price;
            while($length - 3 > 0) {
                $result[] = substr($tmpPrice, $length - 4, 3);
                $tmpPrice = substr($tmpPrice, 0, $length - 3);
                $length -= 3;
            }
            $result[] = $tmpPrice;
            $result = array_reverse($result);
            return join('.', $result);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
