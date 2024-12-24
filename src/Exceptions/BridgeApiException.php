<?php

namespace Intervalle\BridgeSDK\Exceptions;

use Throwable;

class BridgeApiException extends \Exception
{
    protected string $endpoint;
    protected array $context;

    /**
     * Constructeur personnalisé pour BridgeApiException.
     *
     * @param string $message Le message de l'erreur.
     * @param int $code Le code HTTP ou erreur spécifique.
     * @param string $endpoint L'URL de l'API où l'erreur s'est produite.
     * @param array $context Contexte supplémentaire (paramètres, réponse API).
     * @param Throwable|null $previous Exception précédente pour le chaînage.
     */
    public function __construct(
        string $message = "",
        int $code = 0,
        string $endpoint = "",
        array $context = [],
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->endpoint = $endpoint;
        $this->context = $context;
    }

    /**
     * Récupère l'endpoint où l'erreur s'est produite.
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * Récupère le contexte associé à l'erreur.
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * Convertit l'exception en tableau pour le logging.
     */
    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'code' => $this->code,
            'endpoint' => $this->endpoint,
            'context' => $this->context,
            'file' => $this->file,
            'line' => $this->line,
        ];
    }
}