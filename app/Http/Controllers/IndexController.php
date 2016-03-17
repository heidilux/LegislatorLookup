<?php
namespace App\Http\Controllers;

use app\Services\SunlightConnection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Laracasts\Utilities\JavaScript\JavaScriptFacade as JavaScript;

class IndexController extends Controller {

    /**
     * Instance of SunlightConnection
     *
     * @var SunlightConnection
     */
    private $leg;

    /**
     * Set some properties
     *
     * @internal param $method
     * @internal param $filter
     * @internal param $query
     * @internal param null $fields
     */
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

        $res = $this->fetchFromApi($this->leg);

        // Set a few variables to be available to the javascript
        $this->setJsVariables($method, $filter);

        $legi = $this->formatResults($res);
        $this->getDemRepBalance($legi);
        return view('index', compact('legi'));
    }

    /**
     * Fetch sponsored bills from api and display to user
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function showSponsoredBills($id)
    {

        $bills = $this->apiBillLookup($id);
        $legislator = $this->apiLegislatorLookup($id);

        $bills = $this->formatResults($bills);
        $legislator = $this->formatResults($legislator);

        return view('lists', compact('bills', 'legislator'));
    }

    /**
     * Fetch committees from api and display to user
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function showCommittees($id)
    {
        $committees = $this->apiCommitteeLookup($id);
        $legislator = $this->apiLegislatorLookup($id);

        $committees = $this->formatResults($committees);
        $legislator = $this->formatResults($legislator);

        return view('lists', compact('committees', 'legislator'));
    }

    /**
     * Look up bills with bioguide_id
     *
     * @param $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function apiBillLookup($id)
    {
        $res = $this->fetchFromApi('bills','sponsor_id', $id);

        return $res;
    }

    /**
     * Look up legislators with bioguide_id
     *
     * @param $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function apiLegislatorLookup($id)
    {
        $res = $this->fetchFromApi('legislators', 'bioguide_id', $id);

        return $res;
    }

    /**
     * Look up committees with bioguide_id
     *
     * @param $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function apiCommitteeLookup($id)
    {
        $res = $this->fetchFromApi('committees','member_ids', $id);

        return $res;
    }

    /**
     * Convert api results into associative array for use in view
     *
     * @param $res
     *
     * @return array
     */
    private function formatResults($res)
    {
        $body = json_decode(json_encode($res->getBody()->getContents()));
        $body = new Collection($body);

        $data = $body->first();
        $data = json_decode($data, true);

        $count = count($data['results']);

        $formatted = [];
        for ($i = 0; $i < $count; $i++) {
            foreach ($data['results'][$i] as $k => $v) {
                $formatted[$i][$k] = $v;
            }
        }

        return $formatted;
    }

    /**
     * Construct the URL, and fetch the results from the API
     *
     * @param $leg
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function fetchFromApi($leg)
    {
        $fields = $leg->getFields();
        $method = $leg->getMethod();
        $filter = $leg->getFilter();
        $query = $leg->getQuery();
        $key = $leg->getApiKey();

        $fields = ($fields ? '&fields=' . $fields : '');

        $url = '/' . $method . '?' . $filter . '=' . $query . $fields . '&apikey=' . $key;

        // To search by zip requires an extra '/' in the URI that obviously
        // couldn't be passed to the route via the slash-delimited params.
        if ($method == 'locate') {
            $url = '/legislators/locate?' . $filter . '=' . $query . $fields . '&apikey=' . $key;
        }

        $res = $this->leg->client->get($url);

        return $res;
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
