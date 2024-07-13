<?php

namespace Modules\FlightTools\Services;

class CalcAeroService
{
    /**
     * Calculates the Standard Temperature (TSTD).
     *
     * @param int $altitude Altitude in feet.
     * @return float Standard temperature in °C.
     */
    public function calculateStandardTemperature(int $altitude): float
    {
        return 15.0 - ($altitude * 2.0 / 1000.0);
    }

    /**
     * Calculates the True Airspeed (VP).
     * 
     * @param int $indicatedAirspeed Indicated airspeed in knots.
     * @param int $altitude Altitude in feet.
     * @param int $temperature Ambient temperature in °C.
     * @param float $standardTemperature Standard temperature in °C.
     * @return float True airspeed in knots.
     */
    public function calculateTrueAirspeed(int $indicatedAirspeed, int $altitude, int $temperature, float $standardTemperature): float
    {
        $altitudeCorrection = $altitude / 600 * 0.01;
        $temperatureCorrection = ($standardTemperature - $temperature) / 5 * 0.01;
        return $indicatedAirspeed + $altitudeCorrection + $temperatureCorrection;
    }

    /**
     * Calculates the Base Factor (FB).
     * 
     * @param float $trueAirspeed True airspeed in knots.
     * @return float Base factor rounded to the nearest integer.
     */
    public function calculateBaseFactor(float $trueAirspeed): float
    {
        return 60 / $trueAirspeed;
    }

    /**
     * Calculates the No-Wind Time (TSV).
     * 
     * @param int $distance Distance in nautical miles.
     * @param float $baseFactor Base factor.
     * @return int No-wind time in minutes.
     */
    public function calculateNoWindTime(int $distance, float $baseFactor): int
    {
        return floor($distance * $baseFactor);
    }

    /**
     * Calculates the Angle to the Wind (A).
     * 
     * @param int $windOrigin Wind origin in degrees.
     * @param int $magneticHeading Magnetic heading in degrees.
     * @return array{'angle': int, 'direction': string} Angle to the wind and direction.
     */
    public function calculateWindAngle(int $windOrigin, int $magneticHeading): array
    {
        if (($windOrigin - $magneticHeading >= -90 && $windOrigin - $magneticHeading <= 90) || ($windOrigin - $magneticHeading <= -270 || $windOrigin - $magneticHeading >= 270)) {
            $angle = $windOrigin - $magneticHeading;
            $direction = 'Headwind';
        } else {
            $angle = $windOrigin - $magneticHeading - 180;
            $direction = 'Tailwind';
        }    
        return ['angle' => abs($angle), 'direction' => $direction];
    }

    /**
     * Calculates the Effective Wind (VE).
     * 
     * @param int $windSpeed Wind speed in knots.
     * @param int $windAngle Angle to the wind in degrees.
     * @return float Effective wind in knots.
     */
    public function calculateEffectiveWind(int $windSpeed, int $windAngle): float
    {
        return $windSpeed * round(cos(deg2rad($windAngle)), 2);
    }

    /**
     * Calculates the Maximum Drift (XM).
     * 
     * @param float $baseFactor Base factor.
     * @param int $windSpeed Wind speed in knots.
     * @return float Maximum drift in degrees.
     */
    public function calculateMaximumDrift(float $baseFactor, int $windSpeed): float
    {
        return $baseFactor * $windSpeed;
    }

    /**
     * Calculates the Sine of a Wind Angle (SINA).
     * 
     * @param int $windAngle Wind angle in degrees.
     * @return array{'sine': float, 'heading': string} Sine of the wind angle and range of angle.
     */
    public function calculateSineOfWindAngle(int $windAngle): array
    {
        if ($windAngle >= 5 && $windAngle <= 30) {
            $sine = $windAngle / 60;
            return ['sine' => $sine, 'heading' => '5° to 30°'];
        } elseif ($windAngle > 30 && $windAngle <= 70) {
            $sine = (floor($windAngle / 10) + 2) / 10;
            return ['sine' => $sine, 'heading' => '30° to 70°'];
        } elseif ($windAngle > 70 && $windAngle <= 90) {
            return ['sine' => 1.0, 'heading' => '70° to 90°'];
        }

        return ['sine' => 0.0, 'heading' => 'Angle out of range'];
    }

    /**
     * Calculates the Drift (X).
     * 
     * @param float $maximumDrift Maximum drift in degrees.
     * @param float $sineOfWindAngle Sine of the wind angle.
     * @return float Drift in degrees.
     */
    public function calculateDrift(float $maximumDrift, float $sineOfWindAngle): float
    {
        return $maximumDrift * $sineOfWindAngle;
    }

    /**
     * Calculates the Ground Speed (VS).
     * 
     * @param float $trueAirspeed True airspeed in knots.
     * @param float $effectiveWind Effective wind in knots.
     * @return int Ground speed in knots, rounded to the nearest integer.
     */
    public function calculateGroundSpeed(float $trueAirspeed, float $effectiveWind): int
    {
        return round($trueAirspeed + $effectiveWind);
    }

    /**
     * Calculates the New Base Factor (NFB).
     * 
     * @param int $groundSpeed Ground speed in knots.
     * @return float New base factor.
     */
    public function calculateNewBaseFactor(int $groundSpeed): float
    {
        return round(60 / $groundSpeed, 2);
    }

    /**
     * Calculates the Wind-Affected Time (TAV).
     * 
     * @param int $distance Distance in nautical miles.
     * @param float $newBaseFactor New base factor.
     * @return int Wind-affected time in minutes.
     */
    public function calculateWindAffectedTime(int $distance, float $newBaseFactor): int
    {
        return floor($distance * $newBaseFactor);
    }

    /**
     * Converts the base factor to seconds per nautical mile if less than 1 minute,
     * otherwise keeps it in minutes per nautical mile.
     *
     * @param float $factor The base factor to be converted.
     * @return array An associative array with the converted value and the corresponding unit.
     */
    public function convertBaseFactor(float $factor): array
    {
        if ($factor < 1) {
            $factorInSeconds = $factor * 60;
            return [
                'value' => round($factorInSeconds),  // No decimals
                'unit'  => 'Sec/Nm'
            ];
        } else {
            return [
                'value' => round($factor),  // No decimals
                'unit'  => 'Min/Nm'
            ];
        }
    }
}
