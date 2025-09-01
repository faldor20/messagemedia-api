<?php

namespace Faldor20\MessagemediaApi\Enum;

use MyCLabs\Enum\Enum;

/**
 * The expiry status of a sender address.
 *
 * @method static ExpiryStatus EXPIRED()
 * @method static ExpiryStatus EXPIRING()
 */
final class ExpiryStatus extends Enum
{
    /**
     * The sender address has expired.
     */
    private const EXPIRED = 'EXPIRED';

    /**
     * The sender address is expiring soon.
     */
    private const EXPIRING = 'EXPIRING';
}