<?php

namespace LoyaltyProgram\Controllers;

use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Templates\Twig;
use LoyaltyProgram\Models\LoyaltyPoints;
use Plenty\Modules\Plugin\DataBase\Contracts\DataBase;

class AdminLoyaltyController extends Controller
{
    public function showPointsList(Twig $twig)
    {
        $db = pluginApp(DataBase::class);
        $pointsList = $db->query(LoyaltyPoints::class)->get();
        return $twig->render('LoyaltyProgram::admin.loyaltyPointsList', ['pointsList' => $pointsList]);
    }

    public function editPointsView(Twig $twig, $customerId)
    {
        $db = pluginApp(DataBase::class);
        $points = $db->query(LoyaltyPoints::class)->where('customerId', '=', $customerId)->first();
        return $twig->render('LoyaltyProgram::admin.editLoyaltyPoints', ['points' => $points]);
    }

    public function updatePoints(Request $request)
    {
        $customerId = $request->get('customer_id');
        $points = $request->get('points');
        $db = pluginApp(DataBase::class);

        $loyaltyPoints = $db->query(LoyaltyPoints::class)->where('customerId', '=', $customerId)->first();
        if ($loyaltyPoints) {
            $loyaltyPoints->points = $points;
            $db->save($loyaltyPoints);
        } else {
            $loyaltyPoints = pluginApp(LoyaltyPoints::class);
            $loyaltyPoints->customerId = $customerId;
            $loyaltyPoints->points = $points;
            $db->save($loyaltyPoints);
        }
        return redirect()->to('admin/loyalty/points');
    }
}
