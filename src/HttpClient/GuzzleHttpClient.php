<?php

namespace Neoxygen\GrapheneDBClient\HttpClient;

use GuzzleHttp\Client,
    GuzzleHttp\Cookie\CookieJar;
use Neoxygen\GrapheneDBClient\Exception\GrapheneDBClientException;

class GuzzleHttpClient
{
    private $client;

    private $jar;

    public function __construct()
    {
        $this->client = new Client();
        $this->jar = new CookieJar();
    }

    public function send($url, $method, $body = null)
    {
        $request = $this->client->createRequest($method, $url, ['body' => $body, 'cookies' => $this->jar]);
        $request->setHeader('Content-Type', 'application/json');

        try {
            $response = $this->client->send($request);
            return (string) $response->getBody();
        } catch (RequestException $e) {
            $m = $e->getRequest() . "\n";
            if ($e->hasResponse()) {
                $m .= $e->getResponse() . "\n";
            }
            throw new GrapheneDBClientException($m);
        }
    }
}