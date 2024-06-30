<?php

namespace Modules\FlightTools\Http\Controllers;

use App\Contracts\Controller;
use Modules\FlightTools\Http\Requests\CalcTodRequest;

/**
 * Class $CLASS$
 * @package 
 */
class CalcTodController extends Controller
{
    
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

        $tod = ($actfl-$fixfl)/3;
        
        $vSpeed = round(5*$gspeed, -2);
        
        return redirect()->route('FlTools.calc_tod.showForm')->withInput()->with([
            'success' => __('FlTools::tools.Success'),
            'calcTod' => $calcTod,            
            'tod' => round($tod,1),
            'vSpeed' => $vSpeed,
        ]);
    }   
}
