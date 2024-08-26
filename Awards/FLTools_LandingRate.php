<?php

namespace Modules\FlightTools\Awards;

use App\Contracts\Award;

class FLTools_LandingRate extends Award
{
    public $name = 'Landing Rate Award';
    public $param_description = 'The maximum landing rate for which to award this reward';

    public function check($landing_rate = null): bool
    {
        // Have the default landing rate if it hasn't been set in the admin
        // It's best to make sure you set a default value if you're using it
        
        $landing_rate = (int) ($landing_rate ?? -300);
        
        if(!$this->user->last_pirep) {
            return false;
        }
        
        $lastLandingRate = $this->user->last_pirep->landing_rate;

        if( $lastLandingRate >= $landing_rate) {
            return true;
        }
        
        return false;
    }
}