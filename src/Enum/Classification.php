<?php

namespace Schoolzine\MessagemediaApi\Enum;

/**
 * The classification of a dedicated number.
 */
enum Classification: string
{
    /**
     * Bronze classification.
     */
    case BRONZE = 'BRONZE';

    /**
     * Silver classification.
     */
    case SILVER = 'SILVER';

    /**
     * Gold classification.
     */
    case GOLD = 'GOLD';
}
