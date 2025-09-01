<?php

namespace Faldor20\MessagemediaApi\Enum;

use MyCLabs\Enum\Enum;

/**
 * The type of sender address.
 *
 * @method static SenderAddressType ALPHANUMERIC()
 * @method static SenderAddressType INTERNATIONAL()
 */
final class SenderAddressType extends Enum
{
    /**
     * An alphanumeric sender ID.
     */
    private const ALPHANUMERIC = 'ALPHANUMERIC';

    /**
     * An international number.
     */
    private const INTERNATIONAL = 'INTERNATIONAL';
}