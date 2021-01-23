<?php

namespace App\Helpers;

use App\Util\Util;
use Illuminate\Support\Facades\Auth;

class Helper
{
    public static function setCurlAndRequestPage($url, $method, $params = null)
    {
        $headers = [];
        $ch = curl_init();
        // $authorization = "Authorization: Bearer " . Auth::user()->api_token;
        // curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        // curl_setopt($ch, CURLOPT_HEADER, 0);
        // curl_setopt($ch, CURLOPT_ENCODING, 0);
        // curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
        // curl_setopt($ch, CURLOPT_TIMEOUT, 240000);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST , $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); 
        curl_setopt($ch, CURLOPT_URL, $url); 

        if ($method == 'GET') {
            curl_setopt($ch, CURLOPT_POST, 0);
        }

        if ($params != null && $method != 'GET') {
            $postData = $params;

            if (is_array($params)){
                $postData = http_build_query($params);
                $headers[] = 'Content-Type: application/x-www-form-url-encoded';
            } elseif (is_string($params) && Util::isJSON($params)) {
                $headers[] = 'Content-Type: application/json';
            }

            // $headers[] = $authorization;

            // curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        $info = curl_getinfo($ch);
        
        $status = $info['http_code'];
        
        $response = json_decode($response, true);
        
        $response['status'] = $status;
        
        return $response;
    }
}