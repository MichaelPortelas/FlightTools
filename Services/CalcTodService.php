<?php

namespace Modules\FlightTools\Services;

class CalcTodService
{
    /**
     * Calcule le TOD (Top of Descent)
     *
     * @param int $actfl
     * @param int $fixfl
     * @return float
     */
    public function calculateTod(int $actfl, int $fixfl): float
    {
        return ($actfl - $fixfl) / 3;
    }

    /**
     * Calcule la vitesse verticale
     *
     * @param int $gspeed
     * @return int
     */
    public function calculateVSpeed(int $gspeed): int
    {
        return round(5 * $gspeed, -2);
    }
}
