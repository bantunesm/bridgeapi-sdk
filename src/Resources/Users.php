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
     * @return string UUID de l'utilisateur créé
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

    /**
     * Liste tous les utilisateurs BridgeAPI.
     *
     * @return array Liste des utilisateurs
     * @throws BridgeApiException
     */
    public function listUsers(): array
    {
        try {
            $response = $this->httpClient->get('/v3/aggregation/users');

            $body = json_decode((string) $response->getBody(), true);
            return $body['resources'] ?? [];
        } catch (\Throwable $e) {
            throw new BridgeApiException(
                'Erreur lors de la récupération de la liste des utilisateurs : ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Récupère les détails d'un utilisateur BridgeAPI.
     *
     * @param string $userUuid UUID de l'utilisateur
     * @return array Détails de l'utilisateur
     * @throws BridgeApiException
     */
    public function getUser(string $userUuid): array
    {
        try {
            $response = $this->httpClient->get("/v3/aggregation/users/{$userUuid}");

            $body = json_decode((string) $response->getBody(), true);
            return $body ?? [];
        } catch (\Throwable $e) {
            throw new BridgeApiException(
                'Erreur lors de la récupération de l\'utilisateur : ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Supprime un utilisateur BridgeAPI.
     *
     * @param string $userUuid UUID de l'utilisateur
     * @return bool Succès de la suppression
     * @throws BridgeApiException
     */
    public function deleteUser(string $userUuid): bool
    {
        try {
            $response = $this->httpClient->delete("/v3/aggregation/users/{$userUuid}");

            return $response->getStatusCode() === 204;
        } catch (\Throwable $e) {
            throw new BridgeApiException(
                'Erreur lors de la suppression de l\'utilisateur : ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}