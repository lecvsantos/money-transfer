<?php
namespace App\Rules\Integration\Notify;

use GuzzleHttp\Client;

class Notify
{
    public function __construct()
    {
        $this->gclient = new Client();
        $this->endpoint = "http://o4d9z.mocklab.io";
    }

    public function request($verb, $url, $body)
    {
        $endpoint = "{$this->endpoint}/{$url}";

        try {
            $result = $this->gclient->$verb(
                $endpoint,
                [
                    'headers' => ['Accept' => "application/json"],
                    'json' => $body,
                    'timeout' => 10
                ]);
            $json = json_decode($result->getBody()->getContents());
            return $json;
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            return (object) ['message' => $e->getMessage(), 'status' => $e->getCode()];
        }
    }
}
