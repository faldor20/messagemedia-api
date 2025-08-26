<?php

namespace Schoolzine\MessagemediaApi\Model;

/**
 * The status of a message.
 */
class GetMessageStatusResponse
{
    /**
     * @var string|null The format of the message.
     */
    public ?string $format = null;

    /**
     * @var string|null Content of the message.
     */
    public ?string $content = null;

    /**
     * @var array|null Metadata for the message specified as a set of key value pairs, each key can be up to 100 characters long and each value can be up to 256 characters long.
     */
    public ?array $metadata = null;

    /**
     * @var string|null Unique ID of this message.
     */
    public ?string $messageId = null;

    /**
     * @var string|null URL replies and delivery reports to this message will be pushed to.
     */
    public ?string $callbackUrl = null;

    /**
     * @var bool|null Request a delivery report for this message.
     */
    public ?bool $deliveryReport = null;

    /**
     * @var string|null Destination number of the message.
     */
    public ?string $destinationNumber = null;

    /**
     * @var string|null Scheduled delivery date time of the message.
     */
    public ?string $scheduled = null;

    /**
     * @var string|null Source number of the message.
     */
    public ?string $sourceNumber = null;

    /**
     * @var string|null Type of source address specified.
     */
    public ?string $sourceNumberType = null;

    /**
     * @var string|null Date time after which the message expires and will not be sent.
     */
    public ?string $messageExpiryTimestamp = null;

    /**
     * @var string|null The status of the message.
     */
    public ?string $status = null;
}