<?php

namespace Intervalle\BridgeSDK;

use GuzzleHttp\Client as Guzzle;
use Intervalle\BridgeSDK\Exceptions\BridgeApiException;
use Intervalle\BridgeSDK\Resources\Users;
use Intervalle\BridgeSDK\Resources\Items;
use Intervalle\BridgeSDK\Resources\Accounts;
use Intervalle\BridgeSDK\Resources\Transactions;
use Intervalle\BridgeSDK\Resources\Stocks;

class BridgeClient
{
    protected BridgeConfig $config;
    protected Guzzle $guzzle;
    protected ?string $appToken = null;

    public function __construct(BridgeConfig $config)
    {
        $this->config = $config;
        $this->guzzle = new Guzzle([
            'base_uri' => $this->config->getBaseUri(),
            // 'timeout' => 10,
        ]);
    }

    /**
     * Obtient (et met en cache) le token d'application (client_credentials).
     */
    public function getAppToken(): string
    {
        if ($this->appToken) {
            return $this->appToken;
        }

        try {
            $response = $this->guzzle->post('/v2/oauth/token', [
                'json' => [
                    'grant_type'    => 'client_credentials',
                    'client_id'     => $this->config->clientId,
                    'client_secret' => $this->config->clientSecret
                ]
            ]);

            $body = json_decode((string)$response->getBody(), true);
            $this->appToken = $body['access_token'] ?? '';

            return $this->appToken;
        } catch (\Throwable $e) {
            throw new BridgeApiException(
                'Could not get application token: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Instancie la ressource "Users"
     */
    public function users(): Users
    {
        return new Users($this->guzzle, $this);
    }

    /**
     * Instancie la ressource "Items"
     */
    public function items(): Items
    {
        return new Items($this->guzzle, $this);
    }

    /**
     * Instancie la ressource "Accounts"
     */
    public function accounts(): Accounts
    {
        return new Accounts($this->guzzle, $this);
    }

    /**
     * Instancie la ressource "Transactions"
     */
    public function transactions(): Transactions
    {
        return new Transactions($this->guzzle, $this);
    }

    /**
     * Instancie la ressource "Stocks"
     */
    public function stocks(): Stocks
    {
        return new Stocks($this->guzzle, $this);
    }
}