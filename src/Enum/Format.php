<?php

namespace Schoolzine\MessagemediaApi\Enum;

/**
 * The format of the message.
 */
enum Format: string
{
    /**
     * SMS message.
     */
    case SMS = 'SMS';

    /**
     * MMS message.
     */
    case MMS = 'MMS';

    /**
     * Text to speech message.
     */
    case TTS = 'TTS';
}
