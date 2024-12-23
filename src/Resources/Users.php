<?php

namespace Intervalle\BridgeSDK\Resources;

use GuzzleHttp\Client;
use Intervalle\BridgeSDK\Exceptions\BridgeApiException;

class Users
{
    protected Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Crée un nouvel utilisateur BridgeAPI.
     *
     * @param string $externalUserId
     * @return string
     * @throws BridgeApiException
     */
    public function createUser(string $externalUserId): string
    {
        try {
            $response = $this->httpClient->post('/v3/aggregation/users', [
                'json' => [
                    'external_user_id' => $externalUserId,
                ],
            ]);

            $body = json_decode((string) $response->getBody(), true);
            return $body['uuid'] ?? throw new BridgeApiException('UUID manquant dans la réponse.');
        } catch (\Throwable $e) {
            throw new BridgeApiException(
                'Erreur lors de la création de l\'utilisateur : ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}