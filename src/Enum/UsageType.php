<?php

namespace Schoolzine\MessagemediaApi\Enum;

/**
 * The usage type of the Sender ID.
 */
enum UsageType: string
{
    /**
     * Alphanumeric sender ID.
     */
    case ALPHANUMERIC = 'ALPHANUMERIC';

    /**
     * Own number sender ID.
     */
    case OWN_NUMBER = 'OWN_NUMBER';

    /**
     * Dedicated number sender ID.
     */
    case DEDICATED = 'DEDICATED';
}
