<?php

namespace Intervalle\BridgeSDK\Resources;

use GuzzleHttp\Client;
use Intervalle\BridgeSDK\Exceptions\BridgeApiException;
use Illuminate\Support\Facades\Log;

class Insights
{
    protected Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Récupère les insights depuis BridgeAPI.
     *
     * @param string $userToken Jeton utilisateur pour l'API
     * @return array Insights récupérés
     * @throws BridgeApiException
     */
    public function getInsights(string $userToken): array
    {
        $endpoint = '/v3/aggregation/insights/category';

        try {
            Log::info('🛠️ Tentative de récupération des insights.', [
                'endpoint' => $endpoint,
                'userToken' => substr($userToken, 0, 10) . '...' // Masquage du token pour la sécurité
            ]);

            $response = $this->httpClient->get($endpoint, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $userToken,
                ],
            ]);

            $body = json_decode((string) $response->getBody(), true);

            return $body ?? [];
        } catch (\Throwable $e) {
            Log::error('Erreur lors de la récupération des insights.', [
                'endpoint' => $endpoint,
                'userToken' => substr($userToken, 0, 10) . '...', // Masquage du token
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
            ]);

            throw new BridgeApiException(
                'Erreur lors de la récupération des insights : ' . $e->getMessage(),
                $e->getCode(),
                $endpoint,
                ['userToken' => substr($userToken, 0, 10) . '...'],
                $e
            );
        }
    }
}