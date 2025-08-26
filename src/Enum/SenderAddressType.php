<?php

namespace Schoolzine\MessagemediaApi\Enum;

/**
 * The type of sender address.
 */
class SenderAddressType extends AbstractEnum
{
    /**
     * An alphanumeric sender ID.
     */
    public const ALPHANUMERIC = 'ALPHANUMERIC';

    /**
     * An international number.
     */
    public const INTERNATIONAL = 'INTERNATIONAL';
}