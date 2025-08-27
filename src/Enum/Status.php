<?php

namespace Faldor20\MessagemediaApi\Enum;

/**
 * The status of the message.
 */
class Status extends AbstractEnum
{
    /**
     * The message is in transit to the carrier.
     */
    public const ENROUTE = 'enroute';

    /**
     * The message has been submitted to the carrier for delivery.
     */
    public const SUBMITTED = 'submitted';

    /**
     * The message has been delivered to the handset.
     */
    public const DELIVERED = 'delivered';

    /**
     * The message has expired and was not delivered.
     */
    public const EXPIRED = 'expired';

    /**
     * The message was rejected by the carrier.
     */
    public const REJECTED = 'rejected';

    /**
     * The message could not be delivered to the handset.
     */
    public const UNDELIVERABLE = 'undeliverable';

    /**
     * The message is queued for delivery.
     */
    public const QUEUED = 'queued';

    /**
     * The message was cancelled.
     */
    public const CANCELLED = 'cancelled';

    /**
     * The message is scheduled for delivery.
     */
    public const SCHEDULED = 'scheduled';
}