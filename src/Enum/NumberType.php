<?php

namespace Faldor20\MessagemediaApi\Enum;

use MyCLabs\Enum\Enum;

/**
 * The type of a dedicated number.
 *
 * @method static NumberType MOBILE()
 * @method static NumberType LANDLINE()
 * @method static NumberType TOLL_FREE()
 * @method static NumberType SHORT_CODE()
 */
final class NumberType extends Enum
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