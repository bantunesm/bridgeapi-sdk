<?php

namespace Intervalle\BridgeSDK\Resources;

use GuzzleHttp\Client;
use Intervalle\BridgeSDK\Exceptions\BridgeApiException;

class ConnectSession
{
    protected Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Crée une session de connexion.
     *
     * @param string $userToken
     * @param string $userEmail
     * @return string
     * @throws BridgeApiException
     */
    public function createSession(string $userToken, string $userEmail): string
    {
        try {
            $response = $this->httpClient->post('/v3/aggregation/connect-sessions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $userToken,
                ],
                'json' => [
                    'user_email' => $userEmail
                ]
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            return $body['url'] ?? throw new BridgeApiException('URL manquante dans la réponse');
        } catch (\Throwable $e) {
            throw new BridgeApiException(
                'Erreur lors de la création de la session : ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}