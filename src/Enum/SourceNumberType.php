<?php

namespace Faldor20\MessagemediaApi\Enum;

use MyCLabs\Enum\Enum;

/**
 * Type of source address specified.
 *
 * @method static SourceNumberType INTERNATIONAL()
 * @method static SourceNumberType ALPHANUMERIC()
 * @method static SourceNumberType SHORTCODE()
 */
final class SourceNumberType extends Enum
{
    /**
     * An international number.
     */
    private const INTERNATIONAL = 'INTERNATIONAL';

    /**
     * An alphanumeric sender ID.
     */
    private const ALPHANUMERIC = 'ALPHANUMERIC';

    /**
     * A short code.
     */
    private const SHORTCODE = 'SHORTCODE';
}