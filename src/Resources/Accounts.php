<?php

namespace Intervalle\BridgeSDK\Resources;

use GuzzleHttp\Client;
use Intervalle\BridgeSDK\Exceptions\BridgeApiException;

class Accounts
{
    protected Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Lister tous les accounts
     *
     * @param string $userToken
     * @return array Liste des items
     * @throws BridgeApiException
     */
    public function listAccounts(string $userToken): array
    {
        try {
            $response = $this->httpClient->get('/v3/aggregation/accounts', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $userToken,
                ],
            ]);

            $body = json_decode((string)$response->getBody(), true);
            return $body['resources'] ?? [];
        } catch (\Throwable $e) {
            throw new BridgeApiException(
                'Erreur lors de la récupération des accounts : ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Récupérer les détails d'un account spécifique
     *
     * @param string $accountId
     * @param string $userToken
     * @return array Détails de l'item
     * @throws BridgeApiException
     */
    public function getItem(string $accountId, string $userToken): array
    {
        try {
            $response = $this->httpClient->get("/v3/aggregation/accounts/{$accountId}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $userToken,
                ],
            ]);

            $body = json_decode((string)$response->getBody(), true);
            return $body ?? [];
        } catch (\Throwable $e) {
            throw new BridgeApiException(
                'Erreur lors de la récupération de l\'account : ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}