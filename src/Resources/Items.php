<?php

namespace Intervalle\BridgeSDK\Resources;

use GuzzleHttp\Client as Guzzle;
use Intervalle\BridgeSDK\BridgeClient;
use Intervalle\BridgeSDK\Exceptions\BridgeApiException;

class Items
{
    protected Guzzle $guzzle;
    protected BridgeClient $client;

    public function __construct(Guzzle $guzzle, BridgeClient $client)
    {
        $this->guzzle = $guzzle;
        $this->client = $client;
    }

    /**
     * Ex: Lister les items d'un utilisateur
     * Docs: https://docs.bridgeapi.io/docs/first-synchronization
     */
    public function listUserItems(string $userUuid): array
    {
        $appToken = $this->client->getAppToken();

        try {
            $response = $this->guzzle->get("/v2/users/$userUuid/items", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $appToken,
                    'Accept'        => 'application/json',
                ],
            ]);
            return json_decode($response->getBody(), true) ?? [];
        } catch (\Throwable $e) {
            throw new BridgeApiException('Error fetching items: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    // ex: createItem, removeItem, getItemStatus, etc.
}