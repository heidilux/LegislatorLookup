<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\App;
use app\Services\SunlightConnection;

class LegislatorController extends Controller
{
    /**
     * Instance of SunlightConnection
     *
     * @var SunlightConnection
     */
    private $api;

    function __construct()
    {
        $this->api = App::make('api');
    }

    /**
     * Display the page for a single legislator
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $legislator = $this->api->getLegislatorById($id);
        $legislator = $legislator[0];
        $legislator = $this->carbonizeDates($legislator);
        unset($legislator['fec_ids']);
        $leg = $legislator;
        $leg['district'] = $this->ordinal($leg['district']);

        return view('index', compact('leg', 'nf'));
    }

    private function ordinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }

    private function carbonizeDates($legislator)
    {
        $born = Carbon::createFromFormat('Y-m-d', $legislator['birthday']);
        $legislator['birthday'] = $born->toFormattedDateString();

        $start = Carbon::createFromFormat('Y-m-d', $legislator['term_start']);
        $legislator['term_start'] = $start->toFormattedDateString();

        $end = Carbon::createFromFormat('Y-m-d', $legislator['term_end']);
        $legislator['term_end'] = $end->toFormattedDateString();

        return $legislator;
    }
}
