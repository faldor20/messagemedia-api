<?php

namespace Schoolzine\MessagemediaApi\Model;

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
}