<?php

namespace LoyaltyProgram\Controllers;

use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use LoyaltyProgram\Models\LoyaltyPoints;
use Plenty\Modules\Plugin\DataBase\Contracts\DataBase;
use Plenty\Plugin\Http\Response;

class LoyaltyController extends Controller
{
    public function show(Request $request)
    {
        $customerId = $request->get('customer_id');
        $db = pluginApp(DataBase::class);
        $points = $db->query(LoyaltyPoints::class)->where('customerId', '=', $customerId)->first();
        return Response::json(['points' => $points ? $points->points : 0]);
    }

    public function addPoints(Request $request)
    {
        $customerId = $request->get('customer_id');
        $points = $request->get('points');
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
        return Response::json(['success' => true]);
    }

    public function redeemPoints(Request $request)
    {
        $customerId = $request->get('customer_id');
        $points = $request->get('points');
        $db = pluginApp(DataBase::class);

        $loyaltyPoints = $db->query(LoyaltyPoints::class)->where('customerId', '=', $customerId)->first();
        if ($loyaltyPoints && $loyaltyPoints->points >= $points) {
            $loyaltyPoints->points -= $points;
            $db->save($loyaltyPoints);
            return Response::json(['success' => true]);
        } else {
            return Response::json(['error' => 'Insufficient points'], 400);
        }
    }
}
