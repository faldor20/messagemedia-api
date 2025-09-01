<?php

namespace Faldor20\MessagemediaApi\Resource;

use Faldor20\MessagemediaApi\Client;
use Faldor20\MessagemediaApi\Enum\Format;
use Faldor20\MessagemediaApi\Enum\SourceNumberType;
use Faldor20\MessagemediaApi\Enum\Status;
use Faldor20\MessagemediaApi\Model\CancelScheduledMessageRequest;
use Faldor20\MessagemediaApi\Model\GetMessageStatusResponse;
use Faldor20\MessagemediaApi\Model\SendMessagesRequest;
use Faldor20\MessagemediaApi\Model\SendMessagesResponse;

/**
 * The Messages API provides a number of endpoints for building powerful two-way messaging applications.
 * It provides access to three main resources: Messages, Delivery Reports, and Replies.
 */
class Messages
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieve the current status of a message using the message ID returned in the send messages end point.
     *
     * @param string $messageId 36 character UUID of the message to retrieve.
     * @return GetMessageStatusResponse
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \Faldor20\MessagemediaApi\Exception\ForbiddenException
     * @throws \Faldor20\MessagemediaApi\Exception\NotFoundException
     * @throws \Faldor20\MessagemediaApi\Exception\UnexpectedStatusCodeException
     */
    public function get(string $messageId): GetMessageStatusResponse
    {
        $request = $this->client->getRequestFactory()->createRequest('GET', '/v1/messages/' . $messageId);
        $response = $this->client->sendRequest($request);
        $this->client->assertExpectedResponse($response, [200], [403, 404]);

        return $this->client->getSerializer()->deserialize(
            $response->getBody()->getContents(),
            GetMessageStatusResponse::class,
            'json'
        );
    }

    /**
     * Cancel a scheduled message that has not yet been delivered.
     * A scheduled message can be cancelled by updating the status of a message from "scheduled" to "cancelled".
     * Only messages with a status of "scheduled" can be cancelled.
     *
     * @param string $messageId 36 character UUID of the message to cancel.
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \Faldor20\MessagemediaApi\Exception\BadRequestException
     * @throws \Faldor20\MessagemediaApi\Exception\ForbiddenException
     * @throws \Faldor20\MessagemediaApi\Exception\NotFoundException
     * @throws \Faldor20\MessagemediaApi\Exception\UnexpectedStatusCodeException
     */
    public function cancel(string $messageId): void
    {
        $requestBody = new CancelScheduledMessageRequest();
        $request = $this->client->getRequestFactory()->createRequest('PUT', '/v1/messages/' . $messageId);
        $json = $this->client->getSerializer()->serialize($requestBody, 'json');
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Accept', 'application/json')
            ->withBody($this->client->getStreamFactory()->createStream($json));
        $response = $this->client->sendRequest($request);
        $this->client->assertExpectedResponse($response, [200], [400, 403, 404]);
    }

    /**
     * Submit one or more (up to 100 per request) SMS, MMS or text to voice messages for delivery.
     *
     * @param SendMessagesRequest $messages The messages to send.
     * @return SendMessagesResponse
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \Faldor20\MessagemediaApi\Exception\BadRequestException
     * @throws \Faldor20\MessagemediaApi\Exception\ForbiddenException
     * @throws \Faldor20\MessagemediaApi\Exception\UnexpectedStatusCodeException
     */
    public function send(SendMessagesRequest $messages): SendMessagesResponse
    {
        $request = $this->client->getRequestFactory()->createRequest('POST', '/v1/messages');
        $json = $this->client->getSerializer()->serialize($messages, 'json');
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Accept', 'application/json')
            ->withBody($this->client->getStreamFactory()->createStream($json));
        $response = $this->client->sendRequest($request);
        $this->client->assertExpectedResponse($response, [202], [400, 403]);

        $sendMessagesResponse = $this->client->getSerializer()->deserialize(
            $response->getBody()->getContents(),
            SendMessagesResponse::class,
            'json'
        );

        return $sendMessagesResponse;
    }
}