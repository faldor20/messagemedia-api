<?php

namespace Schoolzine\MessagemediaApi\Enum;

/**
 * The capability of a dedicated number.
 */
enum Capability: string
{
    /**
     * SMS capability.
     */
    case SMS = 'SMS';

    /**
     * TTS capability.
     */
    case TTS = 'TTS';

    /**
     * MMS capability.
     */
    case MMS = 'MMS';
}
