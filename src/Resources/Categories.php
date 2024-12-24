<?php

namespace Intervalle\BridgeSDK\Resources;

use GuzzleHttp\Client;
use Intervalle\BridgeSDK\Exceptions\BridgeApiException;
use Illuminate\Support\Facades\Log;

class Categories
{
    protected Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Liste toutes les catégories BridgeAPI.
     *
     * @return array Liste des catégories
     * @throws BridgeApiException
     */
    public function listCategories(): array
    {
        Log::info('BridgeSDK: Début de la récupération de toutes les catégories.');

        try {
            $response = $this->httpClient->get('/v3/aggregation/categories');

            $body = json_decode((string)$response->getBody(), true);

            Log::info('BridgeSDK: Récupération réussie des catégories.', [
                'count' => count($body['resources'] ?? [])
            ]);

            return $body['resources'] ?? [];
        } catch (\Throwable $e) {
            Log::error('BridgeSDK: Erreur lors de la récupération des catégories.', [
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ]);

            throw new BridgeApiException(
                'Erreur lors de la récupération des catégories : ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Récupère les détails d'une catégorie BridgeAPI.
     *
     * @param string|int $categoryId L'ID de la catégorie
     * @return array Détails de la catégorie
     * @throws BridgeApiException
     */
    public function getCategory($categoryId): array
    {
        Log::info('BridgeSDK: Début de la récupération des détails de la catégorie.', [
            'categoryId' => $categoryId
        ]);

        try {
            $response = $this->httpClient->get("/v3/aggregation/categories/{$categoryId}");

            $body = json_decode((string)$response->getBody(), true);

            Log::info('BridgeSDK: Détails de la catégorie récupérés avec succès.', [
                'categoryId' => $categoryId,
                'categoryName' => $body['name'] ?? 'N/A'
            ]);

            return $body ?? [];
        } catch (\Throwable $e) {
            Log::error('BridgeSDK: Erreur lors de la récupération des détails de la catégorie.', [
                'categoryId' => $categoryId,
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ]);

            throw new BridgeApiException(
                'Erreur lors de la récupération des détails de la catégorie : ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}