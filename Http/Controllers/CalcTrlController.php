<?php

namespace Modules\FlightTools\Http\Controllers;

use App\Contracts\Controller;
use Modules\FlightTools\Http\Requests\CalcTrlRequest;

/**
 * Class $CLASS$
 * @package 
 */
class CalcTrlController extends Controller
{
    
    public function showForm()
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

    public function calcTrl(CalcTrlRequest $request)
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

        return redirect()->route('FlTools.calc_trl.showForm')->withInput()->with([
            'success' => __('FlTools::tools.Success'),
            'calcTrl' => $calcTrl,
            'alt1013' => $alt1013,
            'flEq10' => $flEq10,
            'trl' => $trl,
            'flEq20' => $flEq20,
        ]);
    }   
}
