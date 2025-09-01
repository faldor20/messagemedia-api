<?php

namespace Faldor20\MessagemediaApi\Enum;

use MyCLabs\Enum\Enum;

/**
 * The usage type of the Sender ID.
 *
 * @method static UsageType ALPHANUMERIC()
 * @method static UsageType OWN_NUMBER()
 * @method static UsageType DEDICATED()
 */
final class UsageType extends Enum
{
    /**
     * Alphanumeric sender ID.
     */
    private const ALPHANUMERIC = 'ALPHANUMERIC';

    /**
     * Own number sender ID.
     */
    private const OWN_NUMBER = 'OWN_NUMBER';

    /**
     * Dedicated number sender ID.
     */
    private const DEDICATED = 'DEDICATED';
}