<?php

namespace Schoolzine\MessagemediaApi;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Schoolzine\MessagemediaApi\Authentication\Authentication;

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
        StreamFactoryInterface $streamFactory = null
    ) {
        $this->authentication = $authentication;
        $this->httpClient = $httpClient ?? $this->discoverHttpClient();
        $this->requestFactory = $requestFactory ?? $this->discoverRequestFactory();
        $this->streamFactory = $streamFactory ?? $this->discoverStreamFactory();
    }

    /**
     * Sends a request to the MessageMedia API.
     *
     * @param RequestInterface $request The request to send.
     * @return ResponseInterface The response from the API.
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $request = $this->authentication->authenticate($request);
        return $this->httpClient->sendRequest($request);
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
}