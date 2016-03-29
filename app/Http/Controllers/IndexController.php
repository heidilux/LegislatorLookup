<?php
namespace App\Http\Controllers;

use app\Services\SunlightConnection;
use Illuminate\Support\Facades\App;
use Laracasts\Utilities\JavaScript\JavaScriptFacade as JavaScript;

class IndexController extends Controller {

    /**
     * Instance of SunlightConnection
     *
     * @var SunlightConnection
     */
    private $leg;

    function __construct()
    {
        $this->leg = App::make('api');
    }

    /**
     * Show the index page with search field
     *
     * @return \Illuminate\View\View
     */
    public function index()
	{
        return view('index');
	}

    /**
     * Fetch results from the API and send appropriate data to the view
     *
     * @param $method  // kind of the first-order subject you're looking for
     * @param $filter  // what are you searching by [zip, id, name, etc]
     * @param $query   // and what are you searching for
     * @param null $fields // not implemented, but allows you to specify which results are returned
     *
     * @return \Illuminate\View\View
     */
    public function apiLookup($method, $filter, $query, $fields = null)
    {
        $this->leg->setMethod($method);
        $this->leg->setFilter($filter);
        $this->leg->setQuery($query);
        $this->leg->setFields($fields);

        $res = $this->leg->fetchFromApi($this->leg);

        // Set a few variables to be available to the javascript
        $this->setJsVariables($method, $filter);

        $legi = $this->leg->formatResults($res);
        $this->getDemRepBalance($legi);
        return view('index', compact('legi'));
    }
    
    /**
     * How many Ds and Rs are in the result set?
     * Create a couple variables for the JS to work with
     *
     * @param array $legislators
     */
    private function getDemRepBalance(array $legislators)
    {
        $rep = 0;
        $dem = 0;

        foreach ($legislators as $leg) {
            ($leg['party'] == 'R') ? $rep++ : $dem++;
        }
        JavaScript::put([
            'rep' => $rep,
            'dem' => $dem
        ]);
    }

    /**
     * We need to set the search button text to be
     * whatever it was the last time it was clicked
     *
     * @param $filter
     *
     * @return string
     */
    private function previousText($filter)
    {
        switch ($filter) {
            case "query":
                $text = "Name";
                break;
            case "zip":
                $text = "Zipcode";
                break;
            case "state":
                $text = "State";
                break;
            default:
                $text = "Name";
        }

        return $text;
    }

    /**
     * Set a couple more variables to be available to the JS
     * so we can set up the search box like it was last time
     *
     * @param $method
     * @param $filter
     */
    private function setJsVariables($method, $filter)
    {
        $text = $this->previousText($filter);
        JavaScript::put(
            [
                'previousFilter' => $filter,
                'previousText'   => $text,
                'previousMethod' => $method
            ]);
    }

}
