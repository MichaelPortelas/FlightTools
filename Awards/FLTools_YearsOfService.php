<?php

namespace Modules\FlightTools\Awards;

use App\Contracts\Award;
use Carbon\Carbon;
use App\Models\Enums\UserState;

class FLTools_YearsOfService extends Award
{
    public $name = 'Years of Service Award';    
    public $param_description = 'Awarded to pilots who have served for a specified number of years';
    
    public function check($minYears = null): bool
    {
        // Set default value if $minYears is null
        $minYears ??= 0;

        // Check if the user is active
        if ($this->user->state !== UserState::ACTIVE) {
            return false;
        }

        // Check if the user has any PIREPs (flights) recorded
        if (!$this->user->pireps()->exists()) {
            return false;
        }

        // Get the user's join date
        $joinDate = $this->user->created_at;

        // Calculate the number of years of service
        $yearsOfService = Carbon::now()->diffInYears($joinDate);

        // Check if the user has reached the minimum years of service required for the award
        return $yearsOfService >= $minYears;
    }
}
