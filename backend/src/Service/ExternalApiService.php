<?php
namespace App\Service;

use GuzzleHttp\Client;

class ExternalApiService
{
    const BEER_API_URL = 'http://ontariobeerapi2.ca/';
    const COUNTRIES_API_URL =  'https://restcountries.eu/rest/v2/name/';

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function importBeers(): array
    {
        $products = $this->client->get(self::BEER_API_URL.'/products')->getBody()->getContents();

        return json_decode($products);
    }

    public function importCountryCodyByName(string $countryName): ?string
    {
        $country = $this->client->get(self::COUNTRIES_API_URL.$countryName)->getBody()->getContents();
        $countryCode = json_decode($country)[0]->alpha2Code;

        return $countryCode;
    }
}