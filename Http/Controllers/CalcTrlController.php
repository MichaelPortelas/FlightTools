<?php

namespace Modules\FlightTools\Http\Controllers;

use App\Contracts\Controller;
use Modules\FlightTools\Http\Requests\CalcTrlRequest;
use Modules\FlightTools\Services\CalcTrlService;

/**
 * Class $CLASS$
 * @package Modules\FlightTools\Http\Controllers 
 */
class CalcTrlController extends Controller
{
    protected $calcTrlService;

    public function __construct(CalcTrlService $calcTrlService)
    {
        $this->calcTrlService = $calcTrlService;
    }

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

        $alt1013 = $this->calcTrlService->calculateAlt1013($qnh, $ta);
        $flEq = $this->calcTrlService->calculateFlEq($alt1013);
        $results = $this->calcTrlService->calculateTrl($flEq);

        return redirect()->route('FlTools.calc_trl.showForm')->withInput()->with([
            'success' => __('FlTools::tools.Success'),
            'calcTrl' => $calcTrl,
            'alt1013' => $alt1013,
            'flEq10' => $results['flEq10'],
            'trl' => $results['trl'],
            'flEq20' => $results['flEq20'],
        ]);
    }   
}
