<?php

namespace LoyaltyProgram\Providers;

use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Modules\Plugin\DataBase\Contracts\Migrate;
use LoyaltyProgram\Models\LoyaltyPoints;

class AdminMenuServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->getApplication()->register(LoyaltyRouteServiceProvider::class);
    }

    public function boot(Dispatcher $dispatcher)
    {
        $dispatcher->listen('plenty.plugin.backend.menu', function($menuBuilder) {
            $menuBuilder->add('LoyaltyProgram', [
                'type' => 'menu',
                'icon' => 'fa-star',
                'name' => 'LoyaltyProgram',
                'link' => '/admin/loyalty/points'
            ]);
            $menuBuilder->addSubmenu('LoyaltyProgram', [
                'type' => 'submenu',
                'name' => 'Settings',
                'link' => '/admin/loyalty/settings'
            ]);
        });
    }
}
