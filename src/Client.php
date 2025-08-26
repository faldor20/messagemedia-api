<?php

namespace Schoolzine\MessagemediaApi;

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
     * @param ClientInterface $httpClient The HTTP client to use for sending requests.
     * @param Authentication $authentication The authentication method to use.
     * @param RequestFactoryInterface $requestFactory A factory for creating requests.
     * @param StreamFactoryInterface $streamFactory A factory for creating streams.
     */
    public function __construct(
        ClientInterface $httpClient,
        Authentication $authentication,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory
    ) {
        $this->httpClient = $httpClient;
        $this->authentication = $authentication;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
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
}