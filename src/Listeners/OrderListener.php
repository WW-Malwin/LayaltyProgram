<?php

namespace LoyaltyProgram\Listeners;

use Plenty\Modules\Order\Events\OrderPaymentEvent;
use Plenty\Modules\Order\Models\Order;
use Plenty\Modules\Plugin\DataBase\Contracts\DataBase;
use LoyaltyProgram\Models\LoyaltyPoints;
use Plenty\Modules\System\Contracts\WebstoreConfigurationRepositoryContract;

class OrderListener
{
    private $webstoreConfigRepo;

    public function __construct(WebstoreConfigurationRepositoryContract $webstoreConfigRepo)
    {
        $this->webstoreConfigRepo = $webstoreConfigRepo;
    }

    public function handleOrderPayment(OrderPaymentEvent $event)
    {
        /** @var Order $order */
        $order = $event->getOrder();

        $customerId = $order->ownerId;
        $orderValue = $order->amounts[0]->invoiceTotal; // Total order value

        // Get points per order value from settings
        $config = $this->webstoreConfigRepo->findByPlentyId((int) getenv('PLENTY_ID'));
        $pointsPerOrderValue = $config->get(0)['pluginSetttings']['LoyaltyProgram.PointsPerOrderValue'] ?? 1;

        // Calculate points based on the order value
        $points = $this->calculatePoints($orderValue, $pointsPerOrderValue);

        // Add points to the customer's account
        $this->addPoints($customerId, $points);
    }

    private function calculatePoints($orderValue, $pointsPerOrderValue)
    {
        // Example: 1 point for every 10 currency units, multiplied by the configured factor
        return floor($orderValue / 10) * $pointsPerOrderValue;
    }

    private function addPoints($customerId, $points)
    {
        /** @var DataBase $db */
        $db = pluginApp(DataBase::class);

        $loyaltyPoints = $db->query(LoyaltyPoints::class)->where('customerId', '=', $customerId)->first();
        if ($loyaltyPoints) {
            $loyaltyPoints->points += $points;
            $db->save($loyaltyPoints);
        } else {
            $loyaltyPoints = pluginApp(LoyaltyPoints::class);
            $loyaltyPoints->customerId = $customerId;
            $loyaltyPoints->points = $points;
            $db->save($loyaltyPoints);
        }
    }
}
