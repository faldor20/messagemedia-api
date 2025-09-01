<?php

namespace Faldor20\MessagemediaApi\Model;

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

    /**
     * GetMessageStatusResponse constructor.
     *
     * @param string|null $format The format of the message
     * @param string|null $content Content of the message
     * @param array|null $metadata Metadata for the message
     * @param string|null $messageId Unique ID of this message
     * @param string|null $callbackUrl URL for replies and delivery reports
     * @param bool|null $deliveryReport Request a delivery report for this message
     * @param string|null $destinationNumber Destination number of the message
     * @param string|null $scheduled Scheduled delivery date time of the message
     * @param string|null $sourceNumber Source number of the message
     * @param string|null $sourceNumberType Type of source address specified
     * @param string|null $messageExpiryTimestamp Date time after which the message expires
     * @param string|null $status The status of the message
     */
    public function __construct(
        ?string $format = null,
        ?string $content = null,
        ?array $metadata = null,
        ?string $messageId = null,
        ?string $callbackUrl = null,
        ?bool $deliveryReport = null,
        ?string $destinationNumber = null,
        ?string $scheduled = null,
        ?string $sourceNumber = null,
        ?string $sourceNumberType = null,
        ?string $messageExpiryTimestamp = null,
        ?string $status = null
    ) {
        $this->format = $format;
        $this->content = $content;
        $this->metadata = $metadata;
        $this->messageId = $messageId;
        $this->callbackUrl = $callbackUrl;
        $this->deliveryReport = $deliveryReport;
        $this->destinationNumber = $destinationNumber;
        $this->scheduled = $scheduled;
        $this->sourceNumber = $sourceNumber;
        $this->sourceNumberType = $sourceNumberType;
        $this->messageExpiryTimestamp = $messageExpiryTimestamp;
        $this->status = $status;
    }
}