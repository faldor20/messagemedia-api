<?php

namespace Schoolzine\MessagemediaApi\Enum;

/**
 * The type of a dedicated number.
 */
class Type extends AbstractEnum
{
    /**
     * Mobile number.
     */
    public const MOBILE = 'MOBILE';

    /**
     * Landline number.
     */
    public const LANDLINE = 'LANDLINE';

    /**
     * Toll-free number.
     */
    public const TOLL_FREE = 'TOLL_FREE';

    /**
     * Short code number.
     */
    public const SHORT_CODE = 'SHORT_CODE';
}