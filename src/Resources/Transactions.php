<?php

namespace Intervalle\BridgeSDK\Resources;

use GuzzleHttp\Client;
use Intervalle\BridgeSDK\Exceptions\BridgeApiException;

class Transactions
{
    protected Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Lister toutes les transactions avec des paramètres optionnels
     *
     * @param string $userToken
     * @param array $params (limit, account_id, since, until)
     * @return array Liste des transactions
     * @throws BridgeApiException
     */
    public function listTransactions(string $userToken, array $params = []): array
    {
        try {
            // Filtrage des paramètres valides
            $queryParams = array_filter([
                'limit' => $params['limit'] ?? 50,
                'account_id' => $params['account_id'] ?? null,
                'since' => $params['since'] ?? null,
                'until' => $params['until'] ?? null,
            ], fn($value) => !is_null($value));

            $response = $this->httpClient->get('/v3/aggregation/transactions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $userToken,
                ],
                'query' => $queryParams,
            ]);

            $body = json_decode((string)$response->getBody(), true);
            return $body['resources'] ?? [];
        } catch (\Throwable $e) {
            throw new BridgeApiException(
                'Erreur lors de la récupération des transactions : ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Récupérer les détails d'une transaction spécifique
     *
     * @param string $transactionId
     * @param string $userToken
     * @return array Détails de la transaction
     * @throws BridgeApiException
     */
    public function getTransaction(string $transactionId, string $userToken): array
    {
        try {
            $response = $this->httpClient->get("/v3/aggregation/transactions/{$transactionId}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $userToken,
                ],
            ]);

            $body = json_decode((string)$response->getBody(), true);
            return $body ?? [];
        } catch (\Throwable $e) {
            throw new BridgeApiException(
                'Erreur lors de la récupération de la transaction : ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}