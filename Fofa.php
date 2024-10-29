<?php

namespace nova\plugin\fofa;

use nova\framework\text\Json;
use nova\framework\text\JsonDecodeException;
use nova\plugin\http\HttpClient;
use nova\plugin\http\HttpException;
use function nova\framework\config;

class Fofa
{
    /**
     * @throws HttpException
     * @throws JsonDecodeException
     */
    public static function query($query):array
    {
        $key = config('fofa_key');
        $url = "https://fofa.info/api/v1/search/all?key=$key&qbase64=".base64_encode($query);
        $http = HttpClient::init($url);
        $response = $http->get()->send();
        if ($response->getHttpCode()!=200)return [];
        $json = Json::decode($response->getBody(),true);
        if ($json['error'] !==false)return [];
        return $json["results"];
    }
}