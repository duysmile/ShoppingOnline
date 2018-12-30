<?php

namespace App\Providers;

use App\Http\ViewComposers\AdminViewComposer;
use App\Http\ViewComposers\ClientViewComposer;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['layout_user.menu_top', 'layout_user.header', 'layout_user.recommend'], ClientViewComposer::class);
        view()->composer(['layout_admin.sidebar'], AdminViewComposer::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
