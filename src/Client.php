<?php

namespace Faldor20\MessagemediaApi;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Nyholm\Psr7\Uri;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Faldor20\MessagemediaApi\Authentication\Authentication;
use Faldor20\MessagemediaApi\Exception\ApiException;
use Faldor20\MessagemediaApi\Exception\BadRequestException;
use Faldor20\MessagemediaApi\Exception\UnauthorizedException;
use Faldor20\MessagemediaApi\Exception\ForbiddenException;
use Faldor20\MessagemediaApi\Exception\ConflictException;
use Faldor20\MessagemediaApi\Exception\NotFoundException;
use Faldor20\MessagemediaApi\Exception\UnexpectedStatusCodeException;

/**
 * The main client for interacting with the MessageMedia API.
 *
 * This client handles authentication and sending requests to the API.
 */
class Client
{
    private ClientInterface $httpClient;
    private Authentication $authentication;
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $streamFactory;
    private string $baseUri;

    /**
     * Client constructor.
     *
     * @param Authentication $authentication The authentication method to use.
     * @param ClientInterface|null $httpClient The HTTP client to use for sending requests.
     *                                         If null, will be discovered automatically.
     * @param RequestFactoryInterface|null $requestFactory A factory for creating requests.
     *                                                     If null, will be discovered automatically.
     * @param StreamFactoryInterface|null $streamFactory A factory for creating streams.
     *                                                   If null, will be discovered automatically.
     */
    public function __construct(
        Authentication $authentication,
        ClientInterface $httpClient = null,
        RequestFactoryInterface $requestFactory = null,
        StreamFactoryInterface $streamFactory = null,
        string $baseUri = 'https://api.messagemedia.com'
    ) {
        $this->authentication = $authentication;
        $this->httpClient = $httpClient ?? $this->discoverHttpClient();
        $this->requestFactory = $requestFactory ?? $this->discoverRequestFactory();
        $this->streamFactory = $streamFactory ?? $this->discoverStreamFactory();
        $this->baseUri = $baseUri;
    }

    /**
     * Sends a request to the MessageMedia API.
     *
     * @param RequestInterface $request The request to send.
     * @return ResponseInterface The response from the API.
     * @throws \Psr\Http\Client\ClientExceptionInterface If the underlying HTTP client fails to send the request.
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $request = $this->ensureAbsoluteRequestUri($request);
        $request = $this->ensureDefaultHeaders($request);
        $request = $this->authentication->authenticate($request);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Validates a response against expected success codes and throws documented exceptions.
     *
     * All other unexpected 4xx/5xx codes will throw UnexpectedStatusCodeException.
     *
     * @param ResponseInterface $response
     * @param int[] $expectedSuccessCodes
     * @throws BadRequestException
     * @throws UnauthorizedException
     * @throws ForbiddenException
     * @throws ConflictException
     * @throws NotFoundException
     * @throws UnexpectedStatusCodeException
     * @return void
     */
    public function assertExpectedResponse(ResponseInterface $response, array $expectedSuccessCodes, array $documentedErrorCodes = []): void
    {
        $statusCode = $response->getStatusCode();
        if (in_array($statusCode, $expectedSuccessCodes, true)) {
            return;
        }

        $bodyString = (string) $response->getBody();
        $decoded = null;
        if ($bodyString !== '') {
            $decoded = json_decode($bodyString, true);
        }

        $isDocumented = in_array($statusCode, $documentedErrorCodes, true);
        if ($isDocumented) {
            $messageFromBody = null;
            if (is_array($decoded) && isset($decoded['message']) && is_string($decoded['message'])) {
                $messageFromBody = $decoded['message'];
            }
            switch ($statusCode) {
                case 400:
                    throw new BadRequestException($messageFromBody ?? 'Bad Request', 400, $response, is_array($decoded) ? $decoded : null);
                case 401:
                    throw new UnauthorizedException($messageFromBody ?? 'Unauthorized', 401, $response, is_array($decoded) ? $decoded : null);
                case 403:
                    throw new ForbiddenException($messageFromBody ?? 'Forbidden', 403, $response, is_array($decoded) ? $decoded : null);
                case 404:
                    throw new NotFoundException($messageFromBody ?? 'Not Found', 404, $response, is_array($decoded) ? $decoded : null);
                case 409:
                    throw new ConflictException($messageFromBody ?? 'Conflict', 409, $response, is_array($decoded) ? $decoded : null);
            }
        }

        $messageFromBody = null;
        if (is_array($decoded) && isset($decoded['message']) && is_string($decoded['message'])) {
            $messageFromBody = $decoded['message'];
        }
        throw new UnexpectedStatusCodeException(($messageFromBody ?? ('Unexpected status code: ' . $statusCode)), $statusCode, $response, is_array($decoded) ? $decoded : null);
    }

    /**
     * Gets the request factory.
     *
     * @return RequestFactoryInterface
     */
    public function getRequestFactory(): RequestFactoryInterface
    {
        return $this->requestFactory;
    }

    /**
     * Gets the stream factory.
     *
     * @return StreamFactoryInterface
     */
    public function getStreamFactory(): StreamFactoryInterface
    {
        return $this->streamFactory;
    }

    /**
     * Gets the base URI used for requests.
     *
     * @return string
     */
    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    /**
     * Access the Messages API resource.
     *
     * @return Resource\Messages
     */
    public function messages(): Resource\Messages
    {
        return new Resource\Messages($this);
    }

    /**
     * Access the Delivery Reports API resource.
     *
     * @return Resource\DeliveryReports
     */
    public function deliveryReports(): Resource\DeliveryReports
    {
        return new Resource\DeliveryReports($this);
    }

    /**
     * Access the Source Address API resource.
     *
     * @return Resource\SourceAddress
     */
    public function sourceAddress(): Resource\SourceAddress
    {
        return new Resource\SourceAddress($this);
    }

    /**
     * Access the Replies API resource.
     *
     * @return Resource\Replies
     */
    public function replies(): Resource\Replies
    {
        return new Resource\Replies($this);
    }

    /**
     * Access the Number Authorisation API resource.
     *
     * @return Resource\NumberAuthorisation
     */
    public function numberAuthorisation(): Resource\NumberAuthorisation
    {
        return new Resource\NumberAuthorisation($this);
    }

    /**
     * Access the Dedicated Numbers API resource.
     *
     * @return Resource\DedicatedNumbers
     */
    public function dedicatedNumbers(): Resource\DedicatedNumbers
    {
        return new Resource\DedicatedNumbers($this);
    }

    /**
     * Discovers an HTTP client implementation.
     *
     * @return ClientInterface
     */
    private function discoverHttpClient(): ClientInterface
    {
        return Psr18ClientDiscovery::find();
    }

    /**
     * Discovers a request factory implementation.
     *
     * @return RequestFactoryInterface
     */
    private function discoverRequestFactory(): RequestFactoryInterface
    {
        return Psr17FactoryDiscovery::findRequestFactory();
    }

    /**
     * Discovers a stream factory implementation.
     *
     * @return StreamFactoryInterface
     */
    private function discoverStreamFactory(): StreamFactoryInterface
    {
        return Psr17FactoryDiscovery::findStreamFactory();
    }

   /**
     * Ensures the request has an absolute URI by prefixing the configured base URI
     * when the request URI lacks a scheme/host.
     *
     * @param RequestInterface $request
     * @return RequestInterface
     */
    private function ensureAbsoluteRequestUri(RequestInterface $request): RequestInterface
    {
        $uri = $request->getUri();
        if ($uri->getScheme() !== '' && $uri->getHost() !== '') {
            return $request;
        }

        $base = rtrim($this->baseUri, '/');
        $path = '/' . ltrim($uri->getPath(), '/');
        $queryString = $uri->getQuery();
        $absolute = $base . $path . ($queryString !== '' ? ('?' . $queryString) : '');

        $newRequest = $this->requestFactory->createRequest($request->getMethod(), $absolute)
            ->withBody($request->getBody());
            
        foreach ($request->getHeaders() as $name => $values) {
            $newRequest = $newRequest->withHeader($name, $values);
        }

        return $newRequest;
    }

    /**
     * Ensures default headers are present on the request.
     * - Adds Accept: application/json if missing
     * - Adds Content-Type: application/json for requests with a body (POST/PUT/PATCH) if missing
     *
     * @param RequestInterface $request
     * @return RequestInterface
     */
    private function ensureDefaultHeaders(RequestInterface $request): RequestInterface
    {
        if (!$request->hasHeader('Accept')) {
            $request = $request->withHeader('Accept', 'application/json');
        }

        $method = strtoupper($request->getMethod());
        if (in_array($method, ['POST', 'PUT', 'PATCH'], true) && !$request->hasHeader('Content-Type')) {
            $request = $request->withHeader('Content-Type', 'application/json');
        }

        return $request;
    }
}
