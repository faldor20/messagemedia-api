<?php

namespace Schoolzine\MessagemediaApi\Enum;

/**
 * The types of a dedicated number.
 */
enum Types: string
{
    /**
     * Mobile number.
     */
    case MOBILE = 'MOBILE';

    /**
     * Landline number.
     */
    case LANDLINE = 'LANDLINE';

    /**
     * Toll-free number.
     */
    case TOLL_FREE = 'TOLL_FREE';

    /**
     * Short code number.
     */
    case SHORT_CODE = 'SHORT_CODE';
}
