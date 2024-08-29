<?php

namespace Modules\FlightTools\Awards;

use App\Contracts\Award;
use App\Models\Pirep;
use App\Models\Enums\PirepState;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class FLTools_LegsInOneDay extends Award
{
    public $name = 'Legs in One Day Award';
    public $param_description = 'Awarded to pilots who complete a specified number of consecutive legs in one day';

    public function check($minLegs = null): bool
    {
        // Set default value if $minLegs is null and cast to int
        $minLegs = (int)($minLegs ?? 1);

        // Retrieve the last PIREP date
        $lastPirep = $this->user->pireps()->latest('submitted_at')->first();
        
        if (!$lastPirep) {
            Log::info("No PIREPs found for user.");
            return false;
        }

        $lastPirepDate = Carbon::createFromFormat('Y-m-d H:i:s', $lastPirep->submitted_at)->format('Y-m-d');

        // Retrieve PIREPs for the user that match the date of the last PIREP
        $pireps = Pirep::where([
                'user_id' => $this->user->id, 
                'state' => PirepState::ACCEPTED
            ])
            ->whereDate('submitted_at', $lastPirepDate)
            ->orderBy('submitted_at', 'asc')
            ->get();

        // Log the content of $pireps for debugging
        Log::info("Retrieved PIREPs for date $lastPirepDate", $pireps->toArray());

        // If the pilot has fewer than the minimum number of validated PIREPs, return false
        if ($pireps->count() < $minLegs) {
            Log::info("Not enough PIREPs to check. Required: $minLegs, Found: " . $pireps->count());
            return false;
        }

        // Check for sequences of PIREPs submitted on the same day
        return $pireps->sliding($minLegs)->contains(function ($legSequence) use ($minLegs) {
            // Log the current sequence for debugging
            Log::info("Checking sequence", $legSequence->toArray());

            if ($legSequence->count() < $minLegs) {
                Log::info("Sequence length is less than $minLegs. Skipping this sequence.");
                return false;
            }

            return $legSequence->every(function ($pirep, $key) use ($legSequence) {
                // Check if the previous leg exists
                if ($key > 0) {
                    $previousLeg = $legSequence[$key - 1] ?? null;

                    if (!$previousLeg) {
                        Log::info("Previous leg does not exist for index " . $key . ". Skipping this leg.");
                        return false;
                    }

                    $currentLeg = $pirep;

                    if (empty($currentLeg->dpt_airport_id)) {
                        Log::info("Current Leg Departure Airport ID is empty. Skipping this leg.");
                        return false;
                    }

                    $connected = $previousLeg->arr_airport_id === $currentLeg->dpt_airport_id;
                    
                    Log::info("Legs connected: " . ($connected ? 'Yes' : 'No'));

                    return $connected;
                } else {
                    Log::info("Skipping the first leg in the sequence as it has no previous leg.");
                    return true;
                }
            });
        });
    }
}
