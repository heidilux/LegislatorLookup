<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class IndexController extends Controller {

	public function index()
	{
        return view('index');
	}

    public function showResult($zip)
    {
        $client = new Client(['base_uri' => 'https://congress.api.sunlightfoundation.com']);
        $res = $client->get('/legislators/locate?zip=' . $zip .
            '&fields=state_name,bioguide_id,first_name,last_name,nickname,chamber,party&apikey=' .
            getenv('API_KEY'));

        $body = json_decode(json_encode($res->getBody()->getContents()));
        $body = new Collection($body);
        //$items = $body->toArray();

        //$data = $legs->toArray();
        $data = $body->first();

        $data = json_decode($data, true);
        $count = count($data['results']);

        $legi = [];
        for ($i = 0; $i < $count; $i++) {
            foreach ($data['results'][$i] as $k => $v)
            {
                $legi[$i][$k] = $v;
            }
        }

        return view('index', compact('legi'));
    }

}
