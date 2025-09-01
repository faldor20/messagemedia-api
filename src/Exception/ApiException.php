<?php

namespace Faldor20\MessagemediaApi\Exception;

use Psr\Http\Message\ResponseInterface;

class ApiException extends \RuntimeException
{
    private ?ResponseInterface $response;
    private ?array $errorBody;

    public function __construct(string $message, int $code = 0, ?ResponseInterface $response = null, ?array $errorBody = null, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->response = $response;
        $this->errorBody = $errorBody;
    }

    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }

    public function getErrorBody(): ?array
    {
        return $this->errorBody;
    }
}


