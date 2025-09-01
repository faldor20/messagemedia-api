<?php

namespace Faldor20\MessagemediaApi\Model;

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

    /**
     * Reply constructor.
     *
     * @param string|null $callbackUrl The URL specified as the callback URL in the original submit message request
     * @param string|null $content Content of the reply
     * @param string|null $dateReceived Date time when the reply was received
     * @param string|null $destinationNumber Address from which this reply was sent to
     * @param string|null $messageId Unique ID of the original message
     * @param array|null $metadata Any metadata that was included in the original submit message request
     * @param string|null $replyId Unique ID of this reply
     * @param string|null $sourceNumber Address from which this reply was received from
     * @param array|null $vendorAccountId The account used to submit the original message
     */
    public function __construct(
        ?string $callbackUrl = null,
        ?string $content = null,
        ?string $dateReceived = null,
        ?string $destinationNumber = null,
        ?string $messageId = null,
        ?array $metadata = null,
        ?string $replyId = null,
        ?string $sourceNumber = null,
        ?array $vendorAccountId = null
    ) {
        $this->callbackUrl = $callbackUrl;
        $this->content = $content;
        $this->dateReceived = $dateReceived;
        $this->destinationNumber = $destinationNumber;
        $this->messageId = $messageId;
        $this->metadata = $metadata;
        $this->replyId = $replyId;
        $this->sourceNumber = $sourceNumber;
        $this->vendorAccountId = $vendorAccountId;
    }
}
