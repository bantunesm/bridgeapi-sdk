<?php

namespace Intervalle\BridgeSDK\Resources;

use GuzzleHttp\Client as Guzzle;
use Intervalle\BridgeSDK\BridgeClient;
use Intervalle\BridgeSDK\Exceptions\BridgeApiException;

class Transactions
{
    protected Guzzle $guzzle;
    protected BridgeClient $client;

    public function __construct(Guzzle $guzzle, BridgeClient $client)
    {
        $this->guzzle = $guzzle;
        $this->client = $client;
    }

    /**
     * Lister les transactions d'un compte
     * (Doc: https://docs.bridgeapi.io/docs/data-fetching)
     */
    public function listAccountTransactions(
        string $userUuid,
        string $accountUuid,
        array $query = []
    ): array {
        $appToken = $this->client->getAppToken();

        try {
            $endpoint = "/v2/users/$userUuid/accounts/$accountUuid/transactions";
            $queryString = http_build_query($query);

            $response = $this->guzzle->get($endpoint . '?' . $queryString, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $appToken,
                    'Accept'        => 'application/json',
                ],
            ]);

            return json_decode($response->getBody(), true) ?? [];
        } catch (\Throwable $e) {
            throw new BridgeApiException('Error fetching transactions: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    // ex: updateTransaction, categorizeTransaction, etc.
}