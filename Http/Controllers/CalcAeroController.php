<?php

namespace Modules\FlightTools\Http\Controllers;

use App\Contracts\Controller;
use Modules\FlightTools\Http\Requests\CalcAeroRequest;
use Modules\FlightTools\Services\CalcAeroService;

/**
 * Class CalcAeroController
 * @package Modules\FlightTools\Http\Controllers
 *
 * Controller for Aero Calculations
 */
class CalcAeroController extends Controller
{
    /**
     * @var CalcAeroService
     */
    protected $CalcAeroService;

    /**
     * Create a new instance of the controller.
     *
     * @param CalcAeroService $calcAeroService
     */
    public function __construct(CalcAeroService $CalcAeroService)
    {
        $this->CalcAeroService = $CalcAeroService;
    }

    /**
     * Displays the form for aero calculations.
     *
     * @return \Illuminate\View\View
     */
    public function showForm()
    {
        $calcAero = false;
        
        $indicatedAirspeed = 113;   // Indicated airspeed in knots
        $altitude = 8500;           // Altitude in feet
        $magneticHeading = 72;      // Magnetic heading in degrees
        $distance = 148;            // Distance in nautical miles
        $windOrigin = 240;          // Wind origin in degrees
        $windSpeed = 15;            // Wind speed in knots
        $temperature = 24;          // Temperature in °C


        return view('FlTools::tools.calc_aero', [
            'calcAero' => $calcAero,
            'indicatedAirspeed' => $indicatedAirspeed,
            'altitude' => $altitude,
            'magneticHeading' => $magneticHeading,
            'distance' => $distance,
            'windOrigin' => $windOrigin,
            'windSpeed' => $windSpeed,
            'temperature' => $temperature,
        ]);
    }

    /**
     * Handles the calculation of aero metrics.
     *
     * @param CalcAeroRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function calculateAeroMetrics(CalcAeroRequest $request)
    {
        $calcAero = true;

        // Retrieve data from the request
        $indicatedAirspeed = $request->indicatedAirspeed; 
        $altitude = $request->altitude;
        $magneticHeading = $request->magneticHeading;
        $distance = $request->distance;
        $windOrigin = $request->windOrigin;
        $windSpeed = $request->windSpeed;
        $temperature = $request->temperature;
	
        // Perform calculations
        $standardTemperature = $this->CalcAeroService->calculateStandardTemperature($altitude);
		$trueAirspeed = $this->CalcAeroService->calculateTrueAirspeed($indicatedAirspeed, $altitude, $temperature, $standardTemperature);
		$baseFactor = $this->CalcAeroService->calculateBaseFactor($trueAirspeed);
        $baseFactorResult = $this->CalcAeroService->convertBaseFactor($baseFactor);
		$noWindTime = $this->CalcAeroService->calculateNoWindTime($distance, $baseFactor);
		$windAngle = $this->CalcAeroService->calculateWindAngle($windOrigin, $magneticHeading);
		$effectiveWind = $this->CalcAeroService->calculateEffectiveWind($windSpeed, $windAngle['angle']);
		$maximumDrift = $this->CalcAeroService->calculateMaximumDrift($baseFactor, $windSpeed);
		$sineOfWindAngle = $this->CalcAeroService->calculateSineOfWindAngle($windAngle['angle']);
		$drift = $this->CalcAeroService->calculateDrift($maximumDrift, $sineOfWindAngle['sine']);
		$groundSpeed = $this->CalcAeroService->calculateGroundSpeed($trueAirspeed, $effectiveWind);
		$newBaseFactor = $this->CalcAeroService->calculateNewBaseFactor($groundSpeed);
        $newBaseFactorResult = $this->CalcAeroService->convertBaseFactor($newBaseFactor);
		$windAffectedTime = $this->CalcAeroService->calculateWindAffectedTime($distance, $newBaseFactor);
        
        // Redirect to the form with the results
        return redirect()->route('FlTools.calc_aero.showForm')->withInput()->with([
            'success' => __('FlTools::tools.Success'),
            'calcAero' => $calcAero,
            'standardTemperature' => $standardTemperature,
            'trueAirspeed' => round($trueAirspeed),
            'baseFactor' => $baseFactorResult['value'],
            'baseFactorUnit' => $baseFactorResult['unit'],
            'noWindTime' => $noWindTime,
            'windAngle' => $windAngle,
            'effectiveWind' => $effectiveWind,
            'maximumDrift' => round($maximumDrift),
            'sineOfWindAngle' => $sineOfWindAngle,
            'drift' => round($drift),
            'groundSpeed' => $groundSpeed,
            'newBaseFactor' => $newBaseFactorResult['value'],
            'newBaseFactorUnit' => $newBaseFactorResult['unit'],
            'windAffectedTime' => $windAffectedTime,
            
        ]);
    }   
}
