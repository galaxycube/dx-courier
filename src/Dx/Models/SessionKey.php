<?php


namespace Dx\Models;

use Dx\Exceptions\InvalidLoginCredentials;
use Dx\Exceptions\InvalidSessionKey;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

/**
 * Class create SessionKey
 * @package Dx\Models
 */
class SessionKey
{
    public string $_accountNumber;
    public string $_serviceCenter;
    private string $_password;

    private string $_sessionKey;

    private bool $_isTesting;


    /**
     * SessionKey constructor.
     * @param string $accountNumber
     * @param string $serviceCenter
     * @param string $password
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws InvalidSessionKey
     */
    public function __construct(string $accountNumber, string $serviceCenter, string $password, bool $isTesting = false)
    {
        if (empty($accountNumber) || empty($serviceCenter) || empty($password)) {
            throw new InvalidLoginCredentials();
        }

        $this->_accountNumber = $accountNumber;
        $this->_serviceCenter = $serviceCenter;
        $this->_password = $password;
        $this->_isTesting = $isTesting;
        $this->getSessionKey();
    }


    /**
     * Create session key
     *
     * @return string
     * @throws InvalidSessionKey
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSessionKey(): string
    {
        //Guzzle client
        $client = new Client();

        $url = 'https://dx-track.com/DespatchManager.API.Service.DM6Lite/DM6LiteService.svc/';
        if($this->_isTesting) {
            $url = 'http://itd.dx-track.com/DespatchManager.API.Service.DM6Lite_Test/DM6LiteService.svc/';
        }

        // login
        $r = $client->post($url . 'GetSessionKey', [
            RequestOptions::JSON => [
                'DXAccountNumber' => $this->_accountNumber,
                'OrigServiceCentre' => $this->_serviceCenter,
                'Password' => $this->_password
            ]
        ]);

        $response = \GuzzleHttp\json_decode($r->getBody());

        //check
        if (!isset($response->SessionKey) || $response->SessionKey == '00000000-0000-0000-0000-000000000000') {

            throw new InvalidSessionKey();

        } else {

            $this->_sessionKey = $response->SessionKey;
        }

        return (string)$this->_sessionKey;
    }
}