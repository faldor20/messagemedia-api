<?php

namespace Faldor20\MessagemediaApi\Enum;

use MyCLabs\Enum\Enum;

/**
 * The type of a dedicated number.
 *
 * @method static Type MOBILE()
 * @method static Type LANDLINE()
 * @method static Type TOLL_FREE()
 * @method static Type SHORT_CODE()
 */
final class Type extends Enum
{
    /**
     * Mobile number.
     */
    private const MOBILE = 'MOBILE';

    /**
     * Landline number.
     */
    private const LANDLINE = 'LANDLINE';

    /**
     * Toll-free number.
     */
    private const TOLL_FREE = 'TOLL_FREE';

    /**
     * Short code number.
     */
    private const SHORT_CODE = 'SHORT_CODE';
}