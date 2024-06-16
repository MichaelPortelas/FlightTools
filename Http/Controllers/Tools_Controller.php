<?php

namespace Modules\FlightTools\Http\Controllers;

use App\Contracts\Controller;
use Illuminate\Http\Request;

/**
 * Class $CLASS$
 * @package 
 */
class Tools_Controller extends Controller
{
    
    public function calc_trl()
    {
        $calcTrl = false;

        $qnh = 1013;
        $ta = 5000;


        return view('FlTools::tools.calc_trl', [
            'calcTrl' => $calcTrl,
            'qnh' => $qnh,
            'ta' => $ta,
        ]);
    }

    public function calcTrl(Request $request)
    {
        $qnh = $request->qnh;
        $ta = $request->ta;
        $calcTrl = true;

        $alt1013 = (-28*($qnh-1013))+$ta;

        $flEq = round($alt1013/100);

        $flEq10 = $flEq + 10;
        $flEq20 = $flEq + 20;

        if(round($flEq10, -1) < $flEq10){
            $trl = round($flEq20, -1);
        }else{
            $trl = round($flEq10, -1);
        }

        return view('FlTools::tools.calc_trl', [
            'calcTrl' => $calcTrl,
            'qnh' => $qnh,
            'ta' => $ta,
            'alt1013'=>$alt1013, 
            'flEq10'=>$flEq10, 
            'trl'=>$trl, 
            'flEq20'=>$flEq20,
        ]);
    }   
}
