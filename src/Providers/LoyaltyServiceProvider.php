<?php
namespace Loyalty\Program\Providers;

use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Events\Dispatcher;

class LoyaltyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->getApplication()->register(LoyaltyRouteServiceProvider::class);
    }

    public function boot(Dispatcher $eventDispatcher)
    {
        $eventDispatcher->listen("Plenty\Modules\Order\Events\OrderChanged", function ($orderChanged) {
            if ($orderChanged->order->status == "completed") {
                $controller = pluginApp(\Loyalty\Program\Controllers\LoyaltyController::class);
                $controller->addPoints($orderChanged->order->id);
            }
        });
    }
}
