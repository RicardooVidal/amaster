<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;

class ApiController
{
    public static function getUrl()
    {
        return env('API');
    }

    public static function request($url, $method = 'GET', $params = null, $token = true)
    {
        if ($token) {
            $token = Auth::user()->api_token;
            $url = ApiController::getUrl() . '/' . $token . $url;
        }

        ApiController::isApiWorking();
        return Helper::setCurlAndRequestPage($url, $method, $params);
    }

    public static function isApiWorking()
    {
        $url = ApiController::getUrl();

        $response = Helper::setCurlAndRequestPage($url . '/status', 'GET');
        if (isset($response['msg'])) 
        {
            if ($response['msg'] != 'OK') {
                throw new ApiException('A API está fora do ar.');
            }
        } else {
            throw new ApiException('A API está fora do ar.');
        }
    }
}
