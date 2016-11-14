<?php

namespace Nerdify\SmsGateway;

use GuzzleHttp\Client as HttpClient;

class SmsGatewayClient
{
    /**
     * The ID of device to send the message from.
     *
     * @var int
     */
    protected $device;

    /**
     * Username for SMS Gateway.
     *
     * @var string
     */
    protected $email;

    /**
     * The HTTP Client instance.
     *
     * @var \GuzzleHttp\Client
     */
    protected $http;

    /**
     * Password for SMS Gateway.
     *
     * @var string
     */
    protected $password;

    /**
     * Create a new client instance.
     *
     * @param HttpClient $http
     * @param string     $email
     * @param string     $password
     * @param int        $device
     */
    public function __construct(HttpClient $http, $email, $password, $device)
    {
        $this->device = $device;
        $this->email = $email;
        $this->http = $http;
        $this->password = $password;
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function send(array $params)
    {
        $base = [
            'device' => $this->device,
            'email' => $this->email,
            'password' => $this->password,
        ];

        $params = array_merge($base, $params);

        $response = $this->http->post('https://smsgateway.me/api/v3/messages/send', [
            'form_params' => $params,
        ]);

        return json_decode($response->getBody(), true);
    }
}
