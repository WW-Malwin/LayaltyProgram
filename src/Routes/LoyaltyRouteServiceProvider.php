<?php
namespace Loyalty\Program\Providers;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;

class LoyaltyRouteServiceProvider extends RouteServiceProvider
{
    public function map(Router $router)
    {
        $router->post("loyalty/add", "Loyalty\Program\Controllers\LoyaltyController@addPoints");
        $router->get("admin/loyalty", "Loyalty\Program\Controllers\AdminLoyaltyController@show");
        $router->post("admin/loyalty/update", "Loyalty\Program\Controllers\AdminLoyaltyController@updatePoints");
    }
}
