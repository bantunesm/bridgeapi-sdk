<?php

namespace Intervalle\BridgeSDK\Resources;

use GuzzleHttp\Client as Guzzle;
use Intervalle\BridgeSDK\BridgeClient;
use Intervalle\BridgeSDK\Exceptions\BridgeApiException;

class Users
{
    protected Guzzle $guzzle;
    protected BridgeClient $client;

    public function __construct(Guzzle $guzzle, BridgeClient $client)
    {
        $this->guzzle = $guzzle;
        $this->client = $client;
    }

    /**
     * Créer un nouvel utilisateur Bridge.
     * Doc: https://docs.bridgeapi.io/docs/user-creation-authentication
     */
    public function create(array $params): array
    {
        // On peut utiliser le token d'app pour autoriser la requête
        $appToken = $this->client->getAppToken();

        try {
            $response = $this->guzzle->post('/v2/users', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $appToken,
                    'Accept'        => 'application/json',
                ],
                'json' => $params,
            ]);

            return json_decode((string)$response->getBody(), true);
        } catch (\Throwable $e) {
            throw new BridgeApiException('Error creating user: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Récupérer l'utilisateur (GET /v2/users/{uuid}).
     */
    public function get(string $userUuid): array
    {
        $appToken = $this->client->getAppToken();

        try {
            $response = $this->guzzle->get('/v2/users/' . $userUuid, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $appToken,
                    'Accept'        => 'application/json',
                ],
            ]);

            return json_decode((string)$response->getBody(), true);
        } catch (\Throwable $e) {
            throw new BridgeApiException('Error fetching user: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    // Tu peux ajouter d’autres méthodes (delete, update, get user access token, etc.)
}