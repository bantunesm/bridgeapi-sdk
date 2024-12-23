<?php

namespace Intervalle\BridgeSDK;

class BridgeConfig
{
    public string $clientId;
    public string $clientSecret;
    public bool $production;

    public function __construct(
        string $clientId,
        string $clientSecret,
        bool $production = false
    ) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->production = $production;
    }

    public function getBaseUri(): string
    {
        return $this->production
            ? 'https://api.bridgeapi.io'
            : 'https://sandbox.bridgeapi.io';
    }
}