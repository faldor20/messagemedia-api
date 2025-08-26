<?php

namespace Schoolzine\MessagemediaApi\Model;

/**
 * A reply to a message.
 */
class Reply
{
    /**
     * @var string|null The URL specified as the callback URL in the original submit message request.
     */
    public ?string $callbackUrl = null;

    /**
     * @var string|null Content of the reply.
     */
    public ?string $content = null;

    /**
     * @var string|null Date time when the reply was received.
     */
    public ?string $dateReceived = null;

    /**
     * @var string|null Address from which this reply was sent to.
     */
    public ?string $destinationNumber = null;

    /**
     * @var string|null Unique ID of the original message.
     */
    public ?string $messageId = null;

    /**
     * @var array|null Any metadata that was included in the original submit message request.
     */
    public ?array $metadata = null;

    /**
     * @var string|null Unique ID of this reply.
     */
    public ?string $replyId = null;

    /**
     * @var string|null Address from which this reply was received from.
     */
    public ?string $sourceNumber = null;

    /**
     * @var array|null The account used to submit the original message.
     */
    public ?array $vendorAccountId = null;
}
