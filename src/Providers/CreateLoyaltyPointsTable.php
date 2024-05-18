<?php
use Plenty\Modules\Plugin\DataBase\Contracts\Migrate;

class CreateLoyaltyPointsTable extends Migrate
{
    public function run()
    {
        if(!Schema::hasTable("loyalty_points"))
        {
            Schema::create("loyalty_points", function (Blueprint $table) {
                $table->increments("id");
                $table->integer("contactId");
                $table->integer("points");
                $table->timestamps();
            });
        }
    }
}
