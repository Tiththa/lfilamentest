<?php

namespace App\Http\Controllers;

use App\Services\APIService;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function testApi()
    {
        $apiService = app(APIService::class);

        $data = [];
        $id = 'LOC000063431315';
        $data['DirectoryIdentifier'] = $id;

        dd($apiService->nbnQualificationProcess($data));

        $loginToken = $apiService->login();

        $parametersAddress = [
            'company_id' => '17',
            'street_number' => '20',
            'street_name' => 'Exhibition Street',
            'street_type' => 'Street',
            'suburb' => 'Melbourne',
            'state' => 'VIC',
            'postcode' => '3000',
        ];

//        $addressCheck = $apiService->checkAddress($parametersAddress);
//
//        $parametersQualification = [
//            'company_id' => '17',
//            'qualification_identifier' => 'LOCDIRECTORYID',
//            'service_type_id' => 3,
//        ];

//        $qualifyService = $apiService->serviceQualify($parametersQualification);


//        dd($addressCheck);
    }
}
