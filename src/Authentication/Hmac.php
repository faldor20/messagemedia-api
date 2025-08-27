<?php

namespace Faldor20\MessagemediaApi\Authentication;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Implements HMAC Authentication for the MessageMedia API.
 *
 * This authentication method signs the request using a HMAC-SHA1 hash.
 */
class Hmac implements Authentication
{
    private string $apiKey;
    private string $apiSecret;
    private StreamFactoryInterface $streamFactory;

    /**
     * Hmac constructor.
     *
     * @param string $apiKey Your MessageMedia API key.
     * @param string $apiSecret Your MessageMedia API secret.
     * @param StreamFactoryInterface $streamFactory A factory for creating streams.
     */
    public function __construct(string $apiKey, string $apiSecret, StreamFactoryInterface $streamFactory)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->streamFactory = $streamFactory;
    }

    /**
     * Authenticates the request using HMAC Authentication.
     *
     * @param RequestInterface $request The request to authenticate.
     * @return RequestInterface The authenticated request.
     */
    public function authenticate(RequestInterface $request): RequestInterface
    {
        // Step 1: Add a Date header to the request
        $date = gmdate('D, d M Y H:i:s T');
        $request = $request->withHeader('Date', $date);

        $signingString = "Date: " . $date . "\n";

        // Step 2: If the request has a body, add a Content-MD5 header
        if ($request->getBody()->getSize() > 0) {
            $body = $request->getBody()->getContents();
            $request = $request->withBody($this->streamFactory->createStream($body)); // Rewind the body
            $contentMd5 = md5($body);
            $request = $request->withHeader('Content-MD5', $contentMd5);
            $signingString .= "Content-MD5: " . $contentMd5 . "\n";
        }

        // Step 3: Create a signing string
        $signingString .= $request->getMethod() . ' ' . $request->getUri()->getPath() . ' HTTP/' . $request->getProtocolVersion();

        // Step 4: Create a SHA1 HMAC hash
        $signature = base64_encode(hash_hmac('sha1', $signingString, $this->apiSecret, true));

        // Step 5: Base64 encode the HMAC hash and include it as the signature in the Authorization header
        $headers = 'Date' . ($request->hasHeader('Content-MD5') ? ' Content-MD5' : '') . ' request-line';
        $authorization = sprintf(
            'hmac username="%s", algorithm="hmac-sha1", headers="%s", signature="%s"',
            $this->apiKey,
            $headers,
            $signature
        );

        return $request->withHeader('Authorization', $authorization);
    }
}