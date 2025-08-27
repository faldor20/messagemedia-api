<?php

namespace Faldor20\MessagemediaApi\Enum;

/**
 * The usage type of the Sender ID.
 */
class UsageType extends AbstractEnum
{
    /**
     * Alphanumeric sender ID.
     */
    public const ALPHANUMERIC = 'ALPHANUMERIC';

    /**
     * Own number sender ID.
     */
    public const OWN_NUMBER = 'OWN_NUMBER';

    /**
     * Dedicated number sender ID.
     */
    public const DEDICATED = 'DEDICATED';
}