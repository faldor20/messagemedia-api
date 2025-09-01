<?php

namespace Faldor20\MessagemediaApi\Enum;

use MyCLabs\Enum\Enum;

/**
 * The classification of a dedicated number.
 * 
 * @method static Classification BRONZE()
 * @method static Classification SILVER()
 * @method static Classification GOLD()
 */
final class Classification extends Enum
{
    /**
     * Bronze classification.
     */
    private const BRONZE = 'BRONZE';

    /**
     * Silver classification.
     */
    private const SILVER = 'SILVER';

    /**
     * Gold classification.
     */
    private const GOLD = 'GOLD';
}