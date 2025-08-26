<?php

namespace Schoolzine\MessagemediaApi\Enum;

/**
 * The status of the message.
 */
enum Status: string
{
    /**
     * The message is in transit to the carrier.
     */
    case ENROUTE = 'enroute';

    /**
     * The message has been submitted to the carrier for delivery.
     */
    case SUBMITTED = 'submitted';

    /**
     * The message has been delivered to the handset.
     */
    case DELIVERED = 'delivered';

    /**
     * The message has expired and was not delivered.
     */
    case EXPIRED = 'expired';

    /**
     * The message was rejected by the carrier.
     */
    case REJECTED = 'rejected';

    /**
     * The message could not be delivered to the handset.
     */
    case UNDELIVERABLE = 'undeliverable';

    /**
     * The message is queued for delivery.
     */
    case QUEUED = 'queued';

    /**
     * The message was cancelled.
     */
    case CANCELLED = 'cancelled';

    /**
     * The message is scheduled for delivery.
     */
    case SCHEDULED = 'scheduled';
}
