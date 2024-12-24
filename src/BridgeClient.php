<?php

namespace Intervalle\BridgeSDK;

use GuzzleHttp\Client as Guzzle;
use Intervalle\BridgeSDK\Exceptions\BridgeApiException;
use Intervalle\BridgeSDK\Resources\Accounts;
use Intervalle\BridgeSDK\Resources\Auth;
use Intervalle\BridgeSDK\Resources\Categories;
use Intervalle\BridgeSDK\Resources\ConnectSession;
use Intervalle\BridgeSDK\Resources\Insights;
use Intervalle\BridgeSDK\Resources\Items;
use Intervalle\BridgeSDK\Resources\Transactions;
use Intervalle\BridgeSDK\Resources\Users;

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

    public function items(): Items
    {
        return new Items($this->guzzle);
    }

    public function accounts(): Accounts
    {
        return new Accounts($this->guzzle);
    }

    public function transactions(): Transactions
    {
        return new Transactions($this->guzzle);
    }

    public function categories(): Categories
    {
        return new Categories($this->guzzle);
    }

    public function insights(): Insights
    {
        return new Insights($this->guzzle);
    }
}