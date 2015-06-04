<?php namespace App\Http\Controllers;

use App\Http\Requests\ZipLookup;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class IndexController extends Controller {

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
        $zip = $lookup->input('zip');

        $res = $this->apiRequest($zip);

        $legi = $this->formatResults($res);

        return view('index', compact('legi'));
    }

    /**
     * Create guzzle client and fetch data
     *
     * @param $zip
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function apiRequest($zip)
    {
        $client = new Client(['base_uri' => 'https://congress.api.sunlightfoundation.com']);
        $res = $client->get(
            '/legislators/locate?zip=' . $zip .
            '&fields=state_name,bioguide_id,first_name,last_name,nickname,chamber,party,
            phone,website,office,contact_form,fax,twitter_id,youtube_id,facebook_id,oc_email
            &apikey=' . getenv('API_KEY'));

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
