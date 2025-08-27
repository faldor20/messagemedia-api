<?php

namespace Faldor20\MessagemediaApi\Authentication;

use Psr\Http\Message\RequestInterface;

/**
 * Implements Basic Authentication for the MessageMedia API.
 *
 * This authentication method uses a base64 encoded API key and secret in the Authorization header.
 */
class Basic implements Authentication
{
    private string $apiKey;
    private string $apiSecret;

    /**
     * Basic constructor.
     *
     * @param string $apiKey Your MessageMedia API key.
     * @param string $apiSecret Your MessageMedia API secret.
     */
    public function __construct(string $apiKey, string $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /**
     * Authenticates the request using Basic Authentication.
     *
     * @param RequestInterface $request The request to authenticate.
     * @return RequestInterface The authenticated request.
     */
    public function authenticate(RequestInterface $request): RequestInterface
    {
        $credentials = base64_encode($this->apiKey . ':' . $this->apiSecret);
        return $request->withHeader('Authorization', 'Basic ' . $credentials);
    }
}