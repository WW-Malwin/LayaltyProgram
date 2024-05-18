<?php

namespace LoyaltyProgram\Providers;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;

class LoyaltyRouteServiceProvider extends RouteServiceProvider
{
    public function map(Router $router)
    {
        // API-Routen
        $router->get('loyalty', 'LoyaltyProgram\Controllers\LoyaltyController@show');
        $router->post('loyalty/add', 'LoyaltyProgram\Controllers\LoyaltyController@addPoints');
        $router->post('loyalty/redeem', 'LoyaltyProgram\Controllers\LoyaltyController@redeemPoints');
        
        // Admin-Routen
        $router->get('admin/loyalty/points', 'LoyaltyProgram\Controllers\AdminLoyaltyController@showPointsList');
        $router->get('admin/loyalty/points/edit/{customerId}', 'LoyaltyProgram\Controllers\AdminLoyaltyController@editPointsView');
        $router->post('admin/loyalty/points/update', 'LoyaltyProgram\Controllers\AdminLoyaltyController@updatePoints');
        $router->get('admin/loyalty/settings', 'LoyaltyProgram\Controllers\AdminLoyaltyController@showSettings');
        $router->post('admin/loyalty/settings', 'LoyaltyProgram\Controllers\AdminLoyaltyController@saveSettings');
    }
}
