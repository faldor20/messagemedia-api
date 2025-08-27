<?php

namespace Faldor20\MessagemediaApi\Enum;

/**
 * The types of a dedicated number.
 */
class Types extends AbstractEnum
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