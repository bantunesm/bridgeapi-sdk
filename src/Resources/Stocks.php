<?php

namespace Intervalle\BridgeSDK\Resources;

use GuzzleHttp\Client as Guzzle;
use Intervalle\BridgeSDK\BridgeClient;
use Intervalle\BridgeSDK\Exceptions\BridgeApiException;

class Stocks
{
    protected Guzzle $guzzle;
    protected BridgeClient $client;

    public function __construct(Guzzle $guzzle, BridgeClient $client)
    {
        $this->guzzle = $guzzle;
        $this->client = $client;
    }

    /**
     * Lister les stocks d'un compte
     * Doc: https://docs.bridgeapi.io/docs/data-fetching
     */
    public function listAccountStocks(string $userUuid, string $accountUuid): array
    {
        $appToken = $this->client->getAppToken();

        try {
            $endpoint = "/v2/users/$userUuid/accounts/$accountUuid/stocks";
            $response = $this->guzzle->get($endpoint, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $appToken,
                    'Accept'        => 'application/json',
                ],
            ]);

            return json_decode($response->getBody(), true) ?? [];
        } catch (\Throwable $e) {
            throw new BridgeApiException('Error fetching stocks: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }
}