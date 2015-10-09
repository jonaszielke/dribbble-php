<?php
namespace Dribbble;

use GuzzleHttp\Client as HttpClient;

class Client
{
    protected $httpClient;

    protected $endpoint = 'http://api.dribbble.com/v1';

    /**
     * Create a new Dribbble Client instance.
     *
     * @param  \GuzzleHttp\Client  $httpClient
     * @todo Make HTTP client swappable
     */
    public function __construct(HttpClient $httpClient = null)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Make a request to the Dribbble API.
     *
     * @param  string  $uri
     * @param  string  $method
     * @param  array   $parameters
     * @throws \Dribbble\ClientException
     * @return string
     */
    public function makeRequest($uri, $method = 'GET', array $parameters = [])
    {
        $options = [];

        switch ($method) {
            case 'GET':
                $options['query'] = $parameters;
                break;
            case 'POST':
            case 'PUT':
                $options['body'] = $parameters;
                break;
        }

        $response = $this->client->request($method, $uri, $options)->json();

        if (in_array($response->getStatusCode(), [400, 422])) {
            throw new ClientException($response->message);
        }

        return $response;
    }

    /**
     * MAke a GET request to the Dribbble API.
     *
     * @param  string  $uri
     * @param  array   $parameters
     */
    public function makeGetRequest($uri, array $parameters = [])
    {
        return $this->request($uri, 'GET', $parameters);
    }

    /**
     * MAke a POST request to the Dribbble API.
     *
     * @param  string  $uri
     * @param  array   $parameters
     */
    public function makePostRequest($uri, array $parameters = [])
    {
        return $this->request($uri, 'POST', $parameters);
    }

    /**
     * MAke a PUT request to the Dribbble API.
     *
     * @param  string  $uri
     * @param  array   $parameters
     */
    public function makePutRequest($uri, array $parameters = [])
    {
        return $this->request($uri, 'PUT', $parameters);
    }

    /**
     * MAke a DELETE request to the Dribbble API.
     *
     * @param  string  $uri
     */
    public function makeDeleteRequest($uri)
    {
        return $this->request($uri, 'DELETE');
    }
}
