<?php

namespace App\Http\Controllers;

use app\Services\SunlightConnection;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

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
        $legislator =  call_user_func_array('array_merge', $legislator);

        return view('index', compact('legislator'));
    }
}
