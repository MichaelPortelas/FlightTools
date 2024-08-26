<?php

namespace Modules\FlightTools\Awards;

use App\Contracts\Award;
use Carbon\Carbon;
use App\Models\Pirep;
use App\Models\Enums\PirepState;

class FLTools_LegsInOneDay extends Award
{
    public $name = 'Legs in One Day Award';
    public $param_description = 'Awarded to pilots who complete a specified number of consecutive legs in one day';

    public function check($minLegs = null): bool
    {
        // Set default value if $minLegs is null and cast to int
        $minLegs = (int)($minLegs ?? 1);

        // Get the current date
        $today = Carbon::now()->format('Y-m-d');

        // Retrieve all validated PIREPs for today
        $todaysPireps = Pirep::where([
                'user_id' => $this->user->id, 
                'state' => PirepState::ACCEPTED
            ])
            ->whereDate('submitted_at', $today)
            ->orderBy('submitted_at', 'asc')
            ->get();

        // If the pilot has fewer than the minimum number of validated PIREPs today, return false
        if ($todaysPireps->count() < $minLegs) {
            return false;
        }

        // Check if there is a sequence of consecutive legs that meets the minimum requirement
        return $todaysPireps->sliding($minLegs)->contains(function ($legSequence) {
            return $legSequence->every(function ($pirep, $key) use ($legSequence) {
                // Check if all consecutive legs connect properly
                return $key === 0 || $legSequence[$key - 1]->arr_airport_id === $pirep->dep_airport_id;
            });
        });
    }
}
