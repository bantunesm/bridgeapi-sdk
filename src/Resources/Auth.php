<?php

namespace Intervalle\BridgeSDK\Resources;

use GuzzleHttp\Client;
use Intervalle\BridgeSDK\Exceptions\BridgeApiException;

class Auth
{
    protected Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Authentifie un utilisateur et récupère son token.
     *
     * @param string $userUuid
     * @return string
     * @throws BridgeApiException
     */
    public function getUserToken(string $userUuid): string
    {
        try {
            $response = $this->httpClient->post('/v3/aggregation/authorization/token', [
                'json' => [
                    'user_uuid' => $userUuid,
                ],
            ]);

            $body = json_decode((string)$response->getBody(), true);
            return $body['access_token'] ?? throw new BridgeApiException('Token manquant dans la réponse.');
        } catch (\Throwable $e) {
            throw new BridgeApiException(
                'Erreur lors de l\'authentification : ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}