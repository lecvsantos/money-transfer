<?php

namespace App\Rules\Integration\Transaction;

use GuzzleHttp\Client;

class Transaction
{
    public function __construct()
    {
        $this->gclient = new Client();
        $this->endpoint = "https://run.mocky.io";
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
