<?php
namespace Loyalty\Program\Controllers;

use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use Plenty\Modules\Plugin\DataBase\Contracts\DataBase;
use Loyalty\Program\Models\LoyaltyPoints;

class AdminLoyaltyController extends Controller
{
    public function show()
    {
        $points = pluginApp(DataBase::class)->query(LoyaltyPoints::class)->get();
        return view(Loyalty::admin.loyalty.manage, [points => $points]);
    }

    public function updatePoints(Request $request)
    {
        $contactId = $request->input(contactId);
        $points = $request->input(points);
        
        $loyaltyPoints = pluginApp(DataBase::class)->query(LoyaltyPoints::class)
            ->where(contactId, =, $contactId)->first();

        if ($loyaltyPoints) {
            $loyaltyPoints->points = $points;
            $loyaltyPoints->save();
        }

        return redirect()->back();
    }
}
