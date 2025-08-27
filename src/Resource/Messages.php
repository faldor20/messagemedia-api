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
     */
    public function get(string $messageId): GetMessageStatusResponse
    {
        $request = $this->client->getRequestFactory()->createRequest('GET', '/v1/messages/' . $messageId);
        $response = $this->client->sendRequest($request);

        $data = json_decode($response->getBody()->getContents(), true);

        $messageStatus = new GetMessageStatusResponse();
        $messageStatus->format = isset($data['format']) ? Format::from($data['format']) : null;
        $messageStatus->content = $data['content'] ?? null;
        $messageStatus->metadata = $data['metadata'] ?? null;
        $messageStatus->messageId = $data['message_id'] ?? null;
        $messageStatus->callbackUrl = $data['callback_url'] ?? null;
        $messageStatus->deliveryReport = $data['delivery_report'] ?? null;
        $messageStatus->destinationNumber = $data['destination_number'] ?? null;
        $messageStatus->scheduled = $data['scheduled'] ?? null;
        $messageStatus->sourceNumber = $data['source_number'] ?? null;
        $messageStatus->sourceNumberType = isset($data['source_number_type']) ? SourceNumberType::from($data['source_number_type']) : null;
        $messageStatus->messageExpiryTimestamp = $data['message_expiry_timestamp'] ?? null;
        $messageStatus->status = isset($data['status']) ? Status::from($data['status']) : null;

        return $messageStatus;
    }

    /**
     * Cancel a scheduled message that has not yet been delivered.
     * A scheduled message can be cancelled by updating the status of a message from "scheduled" to "cancelled".
     * Only messages with a status of "scheduled" can be cancelled.
     *
     * @param string $messageId 36 character UUID of the message to cancel.
     */
    public function cancel(string $messageId): void
    {
        $requestBody = new CancelScheduledMessageRequest();
        $request = $this->client->getRequestFactory()->createRequest('PUT', '/v1/messages/' . $messageId);
        $request = $request->withBody($this->client->getStreamFactory()->createStream(json_encode($requestBody)));

        $this->client->sendRequest($request);
    }

    /**
     * Submit one or more (up to 100 per request) SMS, MMS or text to voice messages for delivery.
     *
     * @param SendMessagesRequest $messages The messages to send.
     * @return SendMessagesResponse
     */
    public function send(SendMessagesRequest $messages): SendMessagesResponse
    {
        $request = $this->client->getRequestFactory()->createRequest('POST', '/v1/messages');
        $request = $request->withBody($this->client->getStreamFactory()->createStream(json_encode($messages, JSON_FORCE_OBJECT)));
        $response = $this->client->sendRequest($request);

        $data = json_decode($response->getBody()->getContents(), true);

        $sendMessagesResponse = new SendMessagesResponse();
        $sendMessagesResponse->messages = $data['messages'] ?? [];

        return $sendMessagesResponse;
    }
}