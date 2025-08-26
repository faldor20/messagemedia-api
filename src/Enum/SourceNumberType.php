<?php

namespace Schoolzine\MessagemediaApi\Enum;

/**
 * Type of source address specified.
 */
enum SourceNumberType: string
{
    /**
     * An international number.
     */
    case INTERNATIONAL = 'INTERNATIONAL';

    /**
     * An alphanumeric sender ID.
     */
    case ALPHANUMERIC = 'ALPHANUMERIC';

    /**
     * A short code.
     */
    case SHORTCODE = 'SHORTCODE';
}
