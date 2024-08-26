<?php

namespace Modules\FlightTools\Awards;

use App\Contracts\Award;
use App\Models\Pirep;
use App\Models\Enums\PirepState;

class FLTools_TotalDistance extends Award
{
    public $name = 'Total Distance Award';
    public $param_description = 'The total distance traveled to obtain this reward';

    public function check($totalDistance = null): bool
    {
        // Set a default value for $totalDistance if it's not provided
        $totalDistance = (int) ($totalDistance ?? 10000);

        // Calculate the total distance for the user's PIREPs that are in state 2 (Accepted)
        $totalDistanceUser = Pirep::where([
                'user_id' => $this->user->id, 
                'state' => PirepState::ACCEPTED
            ])
            ->sum('distance');            
        
        // Return true if the total distance meets or exceeds the required value
        return $totalDistanceUser >= $totalDistance;
        
    }
}