<?php

namespace Schoolzine\MessagemediaApi\Enum;

/**
 * Type of source address specified.
 */
class SourceNumberType extends AbstractEnum
{
    /**
     * An international number.
     */
    public const INTERNATIONAL = 'INTERNATIONAL';

    /**
     * An alphanumeric sender ID.
     */
    public const ALPHANUMERIC = 'ALPHANUMERIC';

    /**
     * A short code.
     */
    public const SHORTCODE = 'SHORTCODE';
}