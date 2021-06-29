<?php


namespace Dx\Models;

use Dx\Exceptions\InvalidSessionKey;

use GuzzleHttp\Client;

/**
 * Wrapper class: send POST call to DX-courier server.
 * @package Dx\Models
 */
class DxHelper
{
    /**
     * @param $sessionKey
     * @param string $command
     * @param array $post
     * @param bool $enableTesting
     * @return array|bool|float|int|object|string|null
     * @throws \GuzzleHttp\Exception\GuzzleException|InvalidSessionKey
     */
    public static function callApi(string $sessionKey, string $command, array $post, bool $enableTesting = false)
    {
        if (empty($sessionKey)) {
            throw new InvalidSessionKey('Error');
        }

        //Guzzle client
        $client = new Client(
            [
                'headers' => [
                    'AuthHeader' => '<AuthHeader><SessionKey>' . $sessionKey . '</SessionKey></AuthHeader>'
                ]
            ]
        );

        $url = 'https://dx-track.com/DespatchManager.API.Service.DM6Lite/DM6LiteService.svc/';
        if($enableTesting) {
            $url = 'http://itd.dx-track.com/DespatchManager.API.Service.DM6Lite_Test/DM6LiteService.svc/';
        }

        $r = $client->post($url . $command, [
            'json' => $post
        ]);

        return \GuzzleHttp\json_decode($r->getBody());
    }
}