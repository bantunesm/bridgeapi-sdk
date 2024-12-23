<?php

namespace Intervalle\BridgeSDK;

class BridgeConfig
{
    public string $clientId;
    public string $clientSecret;
    public string $apiVersion;

    public function __construct(string $clientId, string $clientSecret, string $apiVersion = '2025-01-15')
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->apiVersion = $apiVersion;
    }

    /**
     * Retourne toujours l'URL de base avec le préfixe /v3.
     */
    public function getBaseUri(): string
    {
        return 'https://api.bridgeapi.io';
    }

    /**
     * Retourne les en-têtes par défaut.
     */
    public function getDefaultHeaders(): array
    {
        return [
            'Bridge-Version' => $this->apiVersion,
            'Client-Id' => $this->clientId,
            'Client-Secret' => $this->clientSecret,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }
}