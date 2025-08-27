<?php

namespace Faldor20\MessagemediaApi\Enum;

/**
 * The format of the message.
 */
class Format extends AbstractEnum
{
    /**
     * SMS message.
     */
    public const SMS = 'SMS';

    /**
     * MMS message.
     */
    public const MMS = 'MMS';

    /**
     * Text to speech message.
     */
    public const TTS = 'TTS';
}