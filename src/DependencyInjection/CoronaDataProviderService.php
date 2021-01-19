<?php

namespace App\DependencyInjection;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CoronaDataProviderService
{
    private $client;
    private $coronaDataUrl;

    public function __construct(HttpClientInterface $client, string $coronaDataUrl)
    {
        $this->client = $client;
        $this->coronaDataUrl = $coronaDataUrl;
    }

    public function getCoronaData()
    {
        $response = $this->client->request(
            'POST',
            $this->coronaDataUrl,
            [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'body' => [
                    "f" => "json",
                    "where" => "1=1",
                    "outFields" => "infiziert,positiv,genesen,verstorben,infiziert_gestern,positiv_gestern,genesen_gestern,verstorben_gestern",
                    "returnGeometry" => "false"
                ],
            ]
        );
        $information = json_decode($response->getContent(), true);

        return $information['features'][0]['attributes'];
    }
}
