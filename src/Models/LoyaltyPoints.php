<?php

namespace LoyaltyProgram\Models;

use Plenty\Modules\Plugin\DataBase\Contracts\Model;

class LoyaltyPoints extends Model
{
    public $id = 0;
    public $customerId;
    public $points;

    protected $fillable = ['customerId', 'points'];

    public function getTableName(): string
    {
        return 'LoyaltyPoints';
    }
}
