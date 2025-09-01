<?php

namespace Faldor20\MessagemediaApi\Enum;

use MyCLabs\Enum\Enum;

/**
 * The types of a dedicated number.
 *
 * @method static Types MOBILE()
 * @method static Types LANDLINE()
 * @method static Types TOLL_FREE()
 * @method static Types SHORT_CODE()
 */
final class Types extends Enum
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