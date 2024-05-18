<?php
namespace Loyalty\Program\Models;

use Plenty\Modules\Plugin\DataBase\Contracts\DataBase;

class LoyaltyPoints extends DataBase
{
    public $contactId;
    public $points;

    protected $table = "loyalty_points";

    public static function addPoints($contactId, $points)
    {
        $loyaltyPoints = new self();
        $loyaltyPoints->contactId = $contactId;
        $loyaltyPoints->points = $points;
        $loyaltyPoints->save();
    }
}
