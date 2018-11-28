<?php

namespace App\Providers;

use App\Model\Permission;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Permission::get()->map(function ($permission) {
            Gate::define($permission->slug, function ($user) use ($permission) {
                return $user->hasPermissionTo($permission);
            });
        });

        Blade::directive('role', function (... $roles) {
            $roleTmp = [];
            foreach ($roles as $role) {
                $roleTmp[] = $role;
            }
            $roleTmp = join(',', $roleTmp);
            return "<?php if(auth()->check() && auth()->user()->hasRole({$roleTmp})) {?>";
        });
        Blade::directive('endrole', function (){
            return "<?php } ?>";
        });
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
