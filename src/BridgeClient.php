<?php

namespace Intervalle\BridgeSDK;

use GuzzleHttp\Client as Guzzle;
use Intervalle\BridgeSDK\Exceptions\BridgeApiException;
use Intervalle\BridgeSDK\Resources\Users;
use Intervalle\BridgeSDK\Resources\Auth;
use Intervalle\BridgeSDK\Resources\ConnectSession;

class BridgeClient
{
    protected BridgeConfig $config;
    protected Guzzle $guzzle;

    public function __construct(BridgeConfig $config)
    {
        $this->config = $config;
        $this->guzzle = new Guzzle([
            'base_uri' => $this->config->getBaseUri(),
            'headers' => [
                'Bridge-Version' => $this->config->apiVersion,
                'Client-Id' => $this->config->clientId,
                'Client-Secret' => $this->config->clientSecret,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function users(): Users
    {
        return new Users($this->guzzle);
    }

    public function auth(): Auth
    {
        return new Auth($this->guzzle);
    }

    public function connectSession(): ConnectSession
    {
        return new ConnectSession($this->guzzle);
    }
}