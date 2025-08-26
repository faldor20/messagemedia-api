<?php

namespace Schoolzine\MessagemediaApi\Enum;

/**
 * The type of sender address.
 */
enum SenderAddressType: string
{
    /**
     * An alphanumeric sender ID.
     */
    case ALPHANUMERIC = 'ALPHANUMERIC';

    /**
     * An international number.
     */
    case INTERNATIONAL = 'INTERNATIONAL';
}
