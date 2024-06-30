<?php

namespace Modules\FlightTools\Services;

class CalcTrlService
{
    /**
     * Calcule l'altitude standardisée à 1013 hPa
     *
     * @param int $qnh
     * @param int $ta
     * @return float
     */
    public function calculateAlt1013(int $qnh, int $ta): float
    {
        return (-28 * ($qnh - 1013)) + $ta;
    }

    /**
     * Calcule le FL équivalent à partir de l'altitude à 1013 hPa
     *
     * @param float $alt1013
     * @return float
     */
    public function calculateFlEq(float $alt1013): float
    {
        return round($alt1013 / 100);
    }

    /**
     * Calcule les FLs proches du FL équivalent
     *
     * @param float $flEq
     * @return array
     */
    public function calculateTrl(float $flEq): array
    {
        $flEq10 = $flEq + 10;
        $flEq20 = $flEq + 20;

        if (round($flEq10, -1) < $flEq10) {
            $trl = round($flEq20, -1);
        } else {
            $trl = round($flEq10, -1);
        }

        return [
            'flEq10' => $flEq10,
            'trl'    => $trl,
            'flEq20' => $flEq20,
        ];
    }
}
