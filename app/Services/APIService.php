<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class APIService
{
    protected string $baseUrl;
    protected ?string $token;

    public function __construct(?string $token = null)
    {
        $this->baseUrl = config('services.sq_check.base_url');
        $this->token = $token;
    }

    /**
     * @throws ConnectionException
     * @throws \Exception
     */
    public function login(): ?string
    {
        $response = Http::acceptJson()
            ->timeout(3)
            ->post($this->baseUrl . 'login', [
                'email' => config('services.sq_check.username'),
                'password' => config('services.sq_check.password'),
        ]);

        if ($response->successful()) {
            // Store the token for future requests
            $this->token = $response->json('result.token');
            return $this->token;
        }

        throw new \Exception('Failed to authenticate: ' . $response->json());

    }


    /**
     * @throws RequestException
     * @throws ConnectionException
     * @throws \Exception
     */
    public function checkAddress(array $data): array
    {
        $response = Http::withHeaders([
            'Content_type' => 'application/json',
            'Accept' => 'application/json',
        ])->connectTimeout(3)
        ->withToken($this->token)
        ->post($this->baseUrl . 'orders/findaddress', $data)->json();

        if ($response->successful()) {
            return $response;
        }

        throw new \Exception('Failed to qualify service: ' . $response->json());

    }


    public function serviceQualify(array $data): array
    {
        $response = Http::withHeaders([
            'Content_type' => 'application/json',
            'Accept' => 'application/json',
        ])->timeout(30)
        ->retry(3, 300,throw: false)
        ->withToken($this->token)
        ->post($this->baseUrl . 'orders/qualify', $data)->json();

        if ($response->successful()) {
            return $response;
        }

        throw new \Exception('Failed to qualify service: ' . $response->json());

    }

    public function qualificationProcess(array $data): array
    {
        // login
        $token = $this->login();

        // check address
        $parametersAddress = [
            'company_id' => '17',
            'street_number' => $data['street_number'],
            'street_name' => $data['street_name'],
            'street_type' => 'Street',
            'suburb' => $data['suburb'],
            'state' => $data['state'],
            'postcode' => $data['postcode'],
        ];

        $addressCheck = $this->checkAddress($parametersAddress);

        // qualify service

        $parametersQualification = [
            'company_id' => '17',
            'qualification_identifier' => $addressCheck['DirectoryIdentifier'],
            'service_type_id' => 3,
        ];

        $qualifyService = $this->serviceQualify($parametersQualification);

        // return the result
        return [
            'result' => $qualifyService[0]['Result'],
            'service_results' => $qualifyService,
        ];

    }

    public function autocompleteResultsDirectNBN($query): array
    {
        $url = 'https://places.nbnco.net.au/places/v1/autocomplete';

        $response = Http::withHeaders([
            'Referer' => 'https://www.nbnco.com.au/',
        ])->withQueryParameters([
            'query' => $query
        ])->get($url);

        if($response->successful()) {
            return $response->json('suggestions');
        } else {
            throw new \Exception('Failed to fetch autocomplete results: ' . $response->json());
        }
    }

    public function nbnQualificationProcess(array $data): array
    {

        // reference
        // https://github.com/LukePrior/nbn-upgrade-map/blob/591de3d9295b03ccea66323e99b2bbb6a9bc2ca0/code/nbn.py#L53

        // login
        $token = $this->login();

        // qualify service

        $parametersQualification = [
            'company_id' => '17',
            'qualification_identifier' => $data['DirectoryIdentifier'],
            'service_type_id' => 3,
        ];

        $qualifyService = $this->serviceQualify($parametersQualification);

        // return the result
        return [
            'result' => $qualifyService[0]['Result'],
        ];

    }

    public function nbnQualificationResults(array $data): string
    {

        // reference
        // https://github.com/LukePrior/nbn-upgrade-map/blob/591de3d9295b03ccea66323e99b2bbb6a9bc2ca0/code/nbn.py#L53

        // login
        $token = $this->login();

        // qualify service

        $url = 'https://places.nbnco.net.au/places/v2/details/';

        $response = Http::withHeaders([
            'Referer' => 'https://www.nbnco.com.au/',
        ])->get($url . $data['DirectoryIdentifier']);

        if (!$response->successful()) {
            return 'error';
        }

        return $response->json('servingArea.serviceStatus');

    }






}
