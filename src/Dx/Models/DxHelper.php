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
     * @return array|bool|float|int|object|string|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function callApi(string $sessionKey, string $command, array $post )
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

        $r = $client->post('http://itd.dx-track.com/DespatchManager.API.Service.DM6Lite_Test/DM6LiteService.svc/' . $command, [

            'json' => $post
            //RequestOptions::JSON => \GuzzleHttp\json_encode($post)
        ]);

        return \GuzzleHttp\json_decode($r->getBody());
    }
}