<?php namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Laracasts\Utilities\JavaScript\JavaScriptFacade as JavaScript;

class IndexController extends Controller {

    private $apiKey;
    private $baseUri;

    function __construct()
    {
        $this->apiKey = getenv('API_KEY');
        $this->baseUri = 'https://congress.api.sunlightfoundation.com';
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
     * Working on a genericized method
     *
     * @param $method  // kind of the first-order subject you're looking for
     * @param $filter  // what are you searching by [party, id, name, etc
     * @param $query   // and what are you searching for
     * @param null $fields
     * @return \Illuminate\View\View
     */
    public function apiLookup($method, $filter, $query, $fields = null)
    {
        $client = new Client(['base_uri' => $this->baseUri]);
        $fields = ($fields ? '&fields=' . $fields : '');

        $url = '/' . $method . '?' . $filter . '=' . $query . $fields . '&apikey=' . $this->apiKey;

        // To search by zip requires an extra '/' in the URI that obviously
        // couldn't be passed to the route via the slash-delimited params.
        if ($method == 'locate') {
            $url = '/legislators/locate?' . $filter . '=' . $query . $fields . '&apikey=' . $this->apiKey;
        }

        $res = $client->get($url);
        $text = $this->previousText($filter);
        JavaScript::put([
            'previousFilter' => $filter,
            'previousText'   => $text,
            'previousMethod' => $method
        ]);

        switch ($method) {
            case "legislators":
                // fallthrough
            case "locate":
                $legi = $this->formatResults($res);
                $this->getDemRepBalance($legi);
                return view('index', compact('legi'));
                break;

            case "committees":
                $committees = $this->formatResults($res);
                $legislator = $this->formatResults($this->apiLegislatorLookup($query));
                return view('lists', compact('committees', 'legislator'));
                break;
        }
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
     * Create guzzle client and perform Bioguide_id lookup
     *
     * @param $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function apiBillLookup($id)
    {
        $client = new Client(['base_uri' => $this->baseUri]);
        $res = $client->get(
            '/bills?sponsor_id=' . $id .
            '&apikey=' . $this->apiKey);

        return $res;
    }

    /**
     * Create guzzle client and perform Bioguide_id lookup
     *
     * @param $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function apiLegislatorLookup($id)
    {
        $client = new Client(['base_uri' => $this->baseUri]);
        $res = $client->get(
            '/legislators?bioguide_id=' . $id .
            '&apikey=' . $this->apiKey);

        return $res;
    }

    /**
     * Convert api results into associative array for use in view
     *
     * @param $res
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

    private function getDemRepBalance(array $legislators)
    {
        $rep = 0;
        $dem = 0;

        foreach ($legislators as $leg) {
            if ($leg['party'] == 'R') {
                $rep++;
            } else {
                $dem++;
            }
        }
        JavaScript::put([
            'rep' => $rep,
            'dem' => $dem
        ]);
    }

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
        }

        return $text;


    }

}
