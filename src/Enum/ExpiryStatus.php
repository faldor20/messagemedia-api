<?php

namespace Schoolzine\MessagemediaApi\Enum;

/**
 * The expiry status of a sender address.
 */
enum ExpiryStatus: string
{
    /**
     * The sender address has expired.
     */
    case EXPIRED = 'EXPIRED';

    /**
     * The sender address is expiring soon.
     */
    case EXPIRING = 'EXPIRING';
}
