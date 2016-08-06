<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteAdminServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers\Admin';

    public function boot(Router $router)
    {
        parent::boot($router);
    }

    public function map(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace, 
            'prefix' => 'admin',
            'middleware' => 'web',
        ], function ($router) {
            require app_path('Http/routes_admin.php');
        });
    }
}
