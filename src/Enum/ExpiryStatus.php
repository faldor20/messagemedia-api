<?php

namespace Faldor20\MessagemediaApi\Enum;

/**
 * The expiry status of a sender address.
 */
class ExpiryStatus extends AbstractEnum
{
    /**
     * The sender address has expired.
     */
    public const EXPIRED = 'EXPIRED';

    /**
     * The sender address is expiring soon.
     */
    public const EXPIRING = 'EXPIRING';
}