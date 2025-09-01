<?php

namespace Faldor20\MessagemediaApi\Model;

/**
 * A delivery report for a message.
 */
class DeliveryReport
{
    /**
     * @var string|null The URL specified as the callback URL in the original submit message request.
     */
    public ?string $callbackUrl = null;

    /**
     * @var string|null Unique ID for this delivery report.
     */
    public ?string $deliveryReportId = null;

    /**
     * @var string|null Address from which this delivery report was received.
     */
    public ?string $sourceNumber = null;

    /**
     * @var string|null The date and time at which this delivery report was generated in UTC.
     */
    public ?string $dateReceived = null;

    /**
     * @var string|null The status of the message.
     */
    public ?string $status = null;

    /**
     * @var int|null Deprecated, no longer in use.
     */
    public ?int $delay = null;

    /**
     * @var string|null The date and time when the message status changed in UTC. For a delivered DR this may indicate the time at which the message was received on the handset.
     */
    public ?string $submittedDate = null;

    /**
     * @var string|null Text of the original message.
     */
    public ?string $originalText = null;

    /**
     * @var string|null Unique ID of the original message.
     */
    public ?string $messageId = null;

    /**
     * @var array|null The account used to submit the original message.
     */
    public ?array $vendorAccountId = null;

    /**
     * @var array|null Any metadata that was included in the original submit message request.
     */
    public ?array $metadata = null;

    /**
     * DeliveryReport constructor.
     *
     * @param string|null $callbackUrl The URL specified as the callback URL in the original submit message request
     * @param string|null $deliveryReportId Unique ID for this delivery report
     * @param string|null $sourceNumber Address from which this delivery report was received
     * @param string|null $dateReceived The date and time at which this delivery report was generated in UTC
     * @param string|null $status The status of the message
     * @param int|null $delay Deprecated, no longer in use
     * @param string|null $submittedDate The date and time when the message status changed in UTC
     * @param string|null $originalText Text of the original message
     * @param string|null $messageId Unique ID of the original message
     * @param array|null $vendorAccountId The account used to submit the original message
     * @param array|null $metadata Any metadata that was included in the original submit message request
     */
    public function __construct(
        ?string $callbackUrl = null,
        ?string $deliveryReportId = null,
        ?string $sourceNumber = null,
        ?string $dateReceived = null,
        ?string $status = null,
        ?int $delay = null,
        ?string $submittedDate = null,
        ?string $originalText = null,
        ?string $messageId = null,
        ?array $vendorAccountId = null,
        ?array $metadata = null
    ) {
        $this->callbackUrl = $callbackUrl;
        $this->deliveryReportId = $deliveryReportId;
        $this->sourceNumber = $sourceNumber;
        $this->dateReceived = $dateReceived;
        $this->status = $status;
        $this->delay = $delay;
        $this->submittedDate = $submittedDate;
        $this->originalText = $originalText;
        $this->messageId = $messageId;
        $this->vendorAccountId = $vendorAccountId;
        $this->metadata = $metadata;
    }
}