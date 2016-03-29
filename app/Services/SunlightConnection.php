<?php
namespace app\Services;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Collection;

class SunlightConnection
{
    /**
     * @var
     */
    private $apiKey;

    /**
     * @var Client
     */
    public $client;

    /**
     * @var
     */
    private $method;

    /**
     * @var
     */
    private $query;

    /**
     * @var
     */
    private $filter;

    /**
     * @var
     */
    private $fields;

    /**
     * @var array
     */
    private $constraints = [];

    /**
     * SunlightConnection constructor.
     *
     * @param $apiKey
     * @param Client $client
     */
    public function __construct($apiKey, Client $client)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return mixed
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * @return mixed
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @param mixed $filter
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    /**
     * @return mixed
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param mixed $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    /**
     * Construct the URL, and fetch the results from the API
     *
     * @param SunlightConnection $query
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function fetchFromApi(SunlightConnection $query)
    {
        $fields = ($query->fields ? '&fields=' . $query->fields : '');
        $constraints = (isset($query->constraints) && is_array($query->constraints)) ? $query->constraints : '';

        $additional = '';
        foreach ($constraints as $filter => $value) {
            $additional .= '&' . $filter . '=' . $value;
        }

        $url = '/' . $query->method .
            '?' . $query->filter .
            '=' . $query->query . $fields . $additional .
            '&apikey=' . $this->apiKey;

        // To search by zip requires an extra '/' in the URI that obviously
        // couldn't be passed to the route via the slash-delimited params.
        if ($this->method == 'locate') {
            $url = '/legislators/locate?' . $this->filter . '=' . $this->query . $fields . '&apikey=' . $this->apiKey;
        }

        $res = $this->client->get($url);

        return $res;
    }

    /**
     * Get the info on a legislator by the bioguide_id
     *
     * @param $id
     *
     * @return array
     */
    public function getLegislatorById($id)
    {
        $this->method = 'legislators';
        $this->filter = 'bioguide_id';
        $this->query = $id;

        $results =  $this->fetchFromApi($this);

        return $this->formatResults($results);
    }

    /**
     * Look up bills with bioguide_id
     *
     * @param $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getBillsById($id)
    {
        $this->method = 'bills';
        $this->filter = 'sponsor_id';
        $this->query = $id;

        $results = $this->fetchFromApi($this);

        return $this->formatResults($results);
    }

    /**
     * Look up committees with bioguide_id
     *
     * @param $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getCommitteesById($id)
    {
        $this->method = 'committees';
        $this->filter = 'member_ids';
        $this->query = $id;

        $results = $this->fetchFromApi($this);

        return $this->formatResults($results);
    }

    /**
     * Convert api results into associative array
     *
     * @param $res
     *
     * @return array
     */
    public function formatResults($res)
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
}