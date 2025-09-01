<?php

namespace Faldor20\MessagemediaApi\Enum;

use MyCLabs\Enum\Enum;

/**
 * The status of the message.
 *
 * @method static Status ENROUTE()
 * @method static Status SUBMITTED()
 * @method static Status DELIVERED()
 * @method static Status EXPIRED()
 * @method static Status REJECTED()
 * @method static Status UNDELIVERABLE()
 * @method static Status QUEUED()
 * @method static Status CANCELLED()
 * @method static Status SCHEDULED()
 */
final class Status extends Enum
{
    /**
     * The message is in transit to the carrier.
     */
    private const ENROUTE = 'enroute';

    /**
     * The message has been submitted to the carrier for delivery.
     */
    private const SUBMITTED = 'submitted';

    /**
     * The message has been delivered to the handset.
     */
    private const DELIVERED = 'delivered';

    /**
     * The message has expired and was not delivered.
     */
    private const EXPIRED = 'expired';

    /**
     * The message was rejected by the carrier.
     */
    private const REJECTED = 'rejected';

    /**
     * The message could not be delivered to the handset.
     */
    private const UNDELIVERABLE = 'undeliverable';

    /**
     * The message is queued for delivery.
     */
    private const QUEUED = 'queued';

    /**
     * The message was cancelled.
     */
    private const CANCELLED = 'cancelled';

    /**
     * The message is scheduled for delivery.
     */
    private const SCHEDULED = 'scheduled';
}