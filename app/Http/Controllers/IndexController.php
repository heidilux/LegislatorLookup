<?php namespace App\Http\Controllers;

use App\Http\Requests\ZipLookup;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

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
     * Fetch results from api and display to user
     *
     * @param ZipLookup $lookup
     * @return \Illuminate\View\View
     */
    public function postZipResult(ZipLookup $lookup)
    {
        $lookup->flash();
        $zip = $lookup->input('zip');

        $res = $this->apiZipLookup($zip);

        $legi = $this->formatResults($res);

        return view('index', compact('legi', 'zip'));
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

        return view('bills', compact('bills', 'legislator'));
    }

    public function apiLookup($method, $filter, $query, $fields = null)
    {
        $client = new Client(['base_uri' => $this->baseUri]);
        $fields = ($fields ? '&fields=' . $fields : '');

        $url = '/' . $method . '?' . $filter . '=' . $query . $fields . '&apikey=' . $this->apiKey;
        //dd($url);
        $res = $client->get($url);

        switch ($method) {
            case "legislators":
                $legi = $this->formatResults($res);
                break;
            case "committees":
                $committees = $this->formatResults($res);
                break;
        }

        return view('index', compact('legi', 'committees'));
    }

    /**
     * Create guzzle client and perform ZipCode lookup
     *
     * @param $zip
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function apiZipLookup($zip)
    {
        $client = new Client(['base_uri' => $this->baseUri]);
        $res = $client->get(
            '/legislators/locate?zip=' . $zip .
            '&fields=state_name,bioguide_id,first_name,last_name,nickname,chamber,party,
            phone,website,office,contact_form,fax,twitter_id,youtube_id,facebook_id,oc_email
            &apikey=' . $this->apiKey);

        return $res;
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

        $legi = [];
        for ($i = 0; $i < $count; $i++) {
            foreach ($data['results'][$i] as $k => $v) {
                $legi[$i][$k] = $v;
            }
        }

        return $legi;
    }

}
