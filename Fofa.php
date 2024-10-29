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
    public static function query($query,$size=5):array
    {
        $key = config('fofa_key');
        $http = HttpClient::init("https://fofa.info");
        $response = $http->get()->send("api/v1/search/all?key=$key&size=$size&qbase64=".base64_encode($query));
        if ($response->getHttpCode()!=200)return [];
        $json = Json::decode($response->getBody(),true);
        if ($json['error'] !==false)return [];
        return $json["results"];
    }
}