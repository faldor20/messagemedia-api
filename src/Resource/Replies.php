<?php

namespace Schoolzine\MessagemediaApi\Resource;

use Schoolzine\MessagemediaApi\Client;
use Schoolzine\MessagemediaApi\Model\CheckRepliesResponse;
use Schoolzine\MessagemediaApi\Model\Reply;

use Schoolzine\MessagemediaApi\Model\ConfirmRepliesAsReceivedRequest;

/**
 * The Replies API allows you to check for replies to your messages.
 * Replies are messages that have been sent from a handset in response to a message sent by an application
 * or messages that have been sent from a handset to a inbound number associated with an account.
 */
class Replies
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Check for any replies that have been received.
     *
     * Each request to the check replies endpoint will return any replies received that
     * have not yet been confirmed using the confirm replies endpoint.
     *
     * It is recommended to use the Webhooks feature to receive reply messages rather than polling this endpoint.
     *
     * @return CheckRepliesResponse
     */
    public function check(): CheckRepliesResponse
    {
        $request = $this->client->getRequestFactory()->createRequest('GET', '/v1/replies');
        $response = $this->client->sendRequest($request);

        $data = json_decode($response->getBody()->getContents(), true);

        $checkRepliesResponse = new CheckRepliesResponse();

        foreach ($data['replies'] as $replyData) {
            $reply = new Reply();
            $reply->callbackUrl = $replyData['callback_url'] ?? null;
            $reply->content = $replyData['content'] ?? null;
            $reply->dateReceived = $replyData['date_received'] ?? null;
            $reply->destinationNumber = $replyData['destination_number'] ?? null;
            $reply->messageId = $replyData['message_id'] ?? null;
            $reply->metadata = $replyData['metadata'] ?? null;
            $reply->replyId = $replyData['reply_id'] ?? null;
            $reply->sourceNumber = $replyData['source_number'] ?? null;
            $reply->vendorAccountId = $replyData['vendor_account_id'] ?? null;
            $checkRepliesResponse->replies[] = $reply;
        }

        return $checkRepliesResponse;
    }

    /**
     * Mark a reply message as confirmed so it is no longer returned in check replies requests.
     *
     * The confirm replies endpoint is intended to be used in conjunction with the check replies endpoint
     * to allow for robust processing of reply messages. Once one or more reply messages have been processed
     * they can then be confirmed using this endpoint so they are no longer returned in subsequent check replies requests.
     *
     * @param ConfirmRepliesAsReceivedRequest $requestBody
     */
    public function confirm(ConfirmRepliesAsReceivedRequest $requestBody): void
    {
        $request = $this->client->getRequestFactory()->createRequest('POST', '/v1/replies/confirmed');
        $request = $request->withBody($this->client->getStreamFactory()->createStream(json_encode($requestBody)));

        $this->client->sendRequest($request);
    }
}