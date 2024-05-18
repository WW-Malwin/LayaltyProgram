<?php

namespace LoyaltyProgram\Providers;

use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Events\Dispatcher;
use LoyaltyProgram\Providers\LoyaltyRouteServiceProvider;

class AdminMenuServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register the route service provider
        $this->getApplication()->register(LoyaltyRouteServiceProvider::class);
    }

    public function boot(Dispatcher $dispatcher)
    {
        // Listen for the backend menu event to add menu items
        $dispatcher->listen('plenty.plugin.backend.menu', function($menuBuilder) {
            // Add main menu item under CRM for the loyalty program
            $menuBuilder->add('CRM', [
                'type' => 'menu',
                'icon' => 'fa-star',
                'name' => 'LoyaltyProgram',
                'link' => '/admin/loyalty/points'
            ]);
            // Add submenu item for settings under the loyalty program
            $menuBuilder->addSubmenu('LoyaltyProgram', [
                'type' => 'submenu',
                'name' => 'Settings',
                'link' => '/admin/loyalty/settings'
            ]);
        });
    }
}
