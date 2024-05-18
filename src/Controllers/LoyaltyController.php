<?php
namespace Loyalty\Program\Controllers;

use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use Plenty\Modules\Order\Models\Order;
use Plenty\Modules\Account\Contact\Contracts\ContactRepositoryContract;
use Loyalty\Program\Models\LoyaltyPoints;

class LoyaltyController extends Controller
{
    private $contactRepository;

    public function __construct(ContactRepositoryContract $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function addPoints(Request $request)
    {
        $orderId = $request->input(orderId);
        $order = Order::find($orderId);

        if($order && $order->status == completed)
        {
            $points = $this->calculatePoints($order);
            $this->storePoints($order->contactId, $points);
        }
    }

    private function calculatePoints($order)
    {
        $points = floor($order->amounts[0]->grossTotal / 10);
        return $points;
    }

    private function storePoints($contactId, $points)
    {
        $contact = $this->contactRepository->findContactById($contactId);
        $loyaltyPoints = new LoyaltyPoints();
        $loyaltyPoints->contactId = $contactId;
        $loyaltyPoints->points = $points;
        $loyaltyPoints->save();
    }
}
