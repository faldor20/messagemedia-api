<?php

namespace Faldor20\MessagemediaApi\Enum;

/**
 * The capability of a dedicated number.
 */
class Capability extends AbstractEnum
{
    /**
     * SMS capability.
     */
    public const SMS = 'SMS';

    /**
     * TTS capability.
     */
    public const TTS = 'TTS';

    /**
     * MMS capability.
     */
    public const MMS = 'MMS';
}