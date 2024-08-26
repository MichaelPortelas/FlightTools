<?php

namespace Modules\FlightTools\Awards;

use App\Contracts\Award;
use Carbon\Carbon;
use App\Models\Enums\PirepState;


class FLTools_LegsInOneDay extends Award
{
    public $name = 'Legs in One Day Award';    
    public $param_description = 'Awarded to pilots who complete a specified number of consecutive legs in one day';
    
    public function check($minLegs = null): bool
    {
        // Set default value if $minLegs is null
        $minLegs ??= 1;

        // Check if the user has any PIREPs (flights) recorded
        if(!$this->user->pireps()->exists())
        {
            return false;
        }
        
        // Get the current date
        $today = Carbon::now()->format('Y-m-d');
        
        // Retrieve all validated PIREPs for today
        $todaysPireps = $this->user->pireps()
            ->whereDate('submitted_at', $today)
            ->where('state', PirepState::ACCEPTED) 
            ->orderBy('submitted_at', 'asc')
            ->get();

        // If the pilot has fewer than the minimum number of validated PIREPs today, return false
        if ($todaysPireps->count() < $minLegs) {
            return false;
        }

        // Check if there is a sequence of consecutive legs that meets the minimum requirement
        for ($i = 0; $i <= $todaysPireps->count() - $minLegs; $i++) {
            $validLegs = true;

            for ($j = 0; $j < $minLegs - 1; $j++) {
                $currentLeg = $todaysPireps[$i + $j];
                $nextLeg = $todaysPireps[$i + $j + 1];
                
                // Check if the arrival of the current leg matches the departure of the next leg
                if ($currentLeg->arr_airport_id !== $nextLeg->dep_airport_id) {
                    $validLegs = false;
                    break;
                }
            }

            // If a valid sequence of legs is found, return true
            if ($validLegs) {
                return true;
            }
        }

        // If no valid sequence is found, return false
        return false;
    }
}
