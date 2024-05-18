<?php

namespace LoyaltyProgram\Providers;

use Plenty\Modules\System\Contracts\WebstoreConfigurationRepositoryContract;
use Plenty\Modules\System\Models\WebstoreConfiguration;

class SettingsHandler
{
    const CONFIG_KEY = 'LoyaltyProgram.PointsPerOrderValue';

    public function handle(array $settings)
    {
        $settings[self::CONFIG_KEY] = $settings['pointsPerOrderValue'];
        return $settings;
    }
}
