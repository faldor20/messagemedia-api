<?php

namespace Faldor20\MessagemediaApi\Enum;

use MyCLabs\Enum\Enum;

/**
 * The format of the message.
 * 
 * @method static Format SMS()
 * @method static Format MMS()
 * @method static Format TTS()
 */
final class Format extends Enum
{
    /**
     * SMS message.
     */
    private const SMS = 'SMS';

    /**
     * MMS message.
     */
    private const MMS = 'MMS';

    /**
     * Text to speech message.
     */
    private const TTS = 'TTS';
}