<?php

namespace Intervalle\BridgeSDK\Resources;

use GuzzleHttp\Client as Guzzle;
use Intervalle\BridgeSDK\BridgeClient;
use Intervalle\BridgeSDK\Exceptions\BridgeApiException;

class Accounts
{
    protected Guzzle $guzzle;
    protected BridgeClient $client;

    public function __construct(Guzzle $guzzle, BridgeClient $client)
    {
        $this->guzzle = $guzzle;
        $this->client = $client;
    }

    /**
     * Lister les comptes d'un user
     * Doc: https://docs.bridgeapi.io/docs/data-fetching
     */
    public function listUserAccounts(string $userUuid): array
    {
        $appToken = $this->client->getAppToken();

        try {
            $response = $this->guzzle->get("/v2/users/$userUuid/accounts", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $appToken,
                    'Accept'        => 'application/json',
                ],
            ]);
            return json_decode($response->getBody(), true) ?? [];
        } catch (\Throwable $e) {
            throw new BridgeApiException('Error fetching accounts: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    // ex: getAccount, etc.
}