<?php

namespace Faldor20\MessagemediaApi\Enum;

use MyCLabs\Enum\Enum;

/**
 * The capability of a dedicated number.
 * 
 * @method static Capability SMS()
 * @method static Capability TTS()
 * @method static Capability MMS()
 */
final class Capability extends Enum
{
    /**
     * SMS capability.
     */
    private const SMS = 'SMS';

    /**
     * TTS capability.
     */
    private const TTS = 'TTS';

    /**
     * MMS capability.
     */
    private const MMS = 'MMS';
}