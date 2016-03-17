<?php

namespace App\Http\Controllers;

use app\Services\SunlightConnection;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class CommitteesController extends Controller
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
     * Display the page listing a legislator's committees
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $committees = $this->api->getCommitteesById($id);
        $legislator = $this->api->getLegislatorById($id);
        $legislator =  call_user_func_array('array_merge', $legislator);

        return view('lists', compact('legislator', 'committees'));
    }
}