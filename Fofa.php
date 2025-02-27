<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace nova\plugin\fofa;

use function nova\framework\config;

use nova\framework\text\Json;
use nova\framework\text\JsonDecodeException;
use nova\plugin\http\HttpClient;

use nova\plugin\http\HttpException;

class Fofa
{
    /**
     * @throws HttpException
     * @throws JsonDecodeException
     */
    public static function query($query, $size = 5): array
    {
        $key = config('fofa_key');
        $http = HttpClient::init("https://fofa.info");
        $response = $http->get()->send("api/v1/search/all?key=$key&size=$size&qbase64=".base64_encode($query));
        if ($response->getHttpCode() != 200) {
            return [];
        }
        $json = Json::decode($response->getBody(), true);
        if ($json['error'] !== false) {
            return [];
        }
        return $json["results"];
    }
}
