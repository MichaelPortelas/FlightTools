<?php

namespace Modules\FlightTools\Http\Controllers;

use App\Contracts\Controller;
use Modules\FlightTools\Http\Requests\CalcTodRequest;
use Modules\FlightTools\Services\CalcTodService;

/**
 * Class $CLASS$
 * @package Modules\FlightTools\Http\Controllers 
 */
class CalcTodController extends Controller
{
    
    protected $calcTodService;

    public function __construct(CalcTodService $calcTodService)
    {
        $this->calcTodService = $calcTodService;
    }

    public function showForm()
    {
        $calcTod = false;

        $actfl = 350;
        $fixfl = 22;
        $gspeed = 154;


        return view('FlTools::tools.calc_tod', [
            'calcTod' => $calcTod,
            'actfl' => $actfl,
            'fixfl' => $fixfl,
            'gspeed' => $gspeed,
        ]);
    }

    public function calcTod(CalcTodRequest $request)
    {
        $actfl = $request->actfl;
        $fixfl = $request->fixfl;
        $gspeed = $request->gspeed;
	
        $calcTod = true;

        $tod = $this->calcTodService->calculateTod($actfl, $fixfl);        
        $vSpeed = $this->calcTodService->calculateVSpeed($gspeed);
        
        return redirect()->route('FlTools.calc_tod.showForm')->withInput()->with([
            'success' => __('FlTools::tools.Success'),
            'calcTod' => $calcTod,            
            'tod' => round($tod,1),
            'vSpeed' => $vSpeed,
        ]);
    }   
}
