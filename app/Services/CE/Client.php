<?php

namespace App\Services\CE;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use JsonException;

class Client
{
    private GuzzleHttpClient $client;
    private array $defaultHeaders;
    private array $apikeyAuth;

    public function __construct()
    {
        $this->client = new GuzzleHttpClient([
            'base_uri' =>  config('services.ce.base_url'),
            'timeout' => 0,
        ]);

        $this->defaultHeaders = [
            'accept' => 'application/json',
        ];
        $this->apikeyAuth = ['apikey' => config('services.ce.apikey')];
    }

    /**
     * @throws GuzzleException
     */
    public function makeRequest($method, $uri, array $params = [], $body = [], $extraHeaders = []): Response
    {
        $response = $this->client->request(
            $method,
            $uri,
            [
                'headers' => array_merge($this->defaultHeaders, $extraHeaders),
                'query' => array_merge($params, $this->apikeyAuth),
                'json' => $body
            ]
        );

        return $response;
    }
}
