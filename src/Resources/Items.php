<?php

namespace Intervalle\BridgeSDK\Resources;

use GuzzleHttp\Client;
use Intervalle\BridgeSDK\Exceptions\BridgeApiException;

class Items
{
    protected Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Lister tous les items
     *
     * @param string $userToken
     * @return array Liste des items
     * @throws BridgeApiException
     */
    public function listItems(string $userToken): array
    {
        try {
            $response = $this->httpClient->get('/v3/aggregation/items', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $userToken,
                ],
            ]);

            $body = json_decode((string)$response->getBody(), true);
            return $body['resources'] ?? [];
        } catch (\Throwable $e) {
            throw new BridgeApiException(
                'Erreur lors de la récupération des items : ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Récupérer les détails d'un item spécifique
     *
     * @param string $itemId
     * @param string $userToken
     * @return array Détails de l'item
     * @throws BridgeApiException
     */
    public function getItem(string $itemId, string $userToken): array
    {
        try {
            $response = $this->httpClient->get("/v3/aggregation/items/{$itemId}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $userToken,
                ],
            ]);

            $body = json_decode((string)$response->getBody(), true);
            return $body ?? [];
        } catch (\Throwable $e) {
            throw new BridgeApiException(
                'Erreur lors de la récupération de l\'item : ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Supprimer un item
     *
     * @param string $itemId
     * @param string $userToken
     * @return bool Succès de la suppression
     * @throws BridgeApiException
     */
    public function deleteItem(string $itemId, string $userToken): bool
    {
        try {
            $response = $this->httpClient->delete("/v3/aggregation/items/{$itemId}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $userToken,
                ],
            ]);

            return $response->getStatusCode() === 204;
        } catch (\Throwable $e) {
            throw new BridgeApiException(
                'Erreur lors de la suppression de l\'item : ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}