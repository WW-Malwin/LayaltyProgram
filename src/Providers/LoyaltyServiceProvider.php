<?php

namespace LoyaltyProgram\Providers;

use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Modules\Plugin\DataBase\Contracts\Migrate;
use LoyaltyProgram\Models\LoyaltyPoints;
use LoyaltyProgram\Listeners\OrderListener;

class LoyaltyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->getApplication()->register(LoyaltyRouteServiceProvider::class);
    }

    public function boot(Dispatcher $dispatcher, Migrate $migrate)
    {
        $migrate->createTable(LoyaltyPoints::class);

        $dispatcher->listen(
            'Plenty\Modules\Order\Events\OrderPaymentEvent',
            OrderListener::class . '@handleOrderPayment'
        );
    }
}
