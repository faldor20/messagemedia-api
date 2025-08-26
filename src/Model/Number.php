<?php

namespace Schoolzine\MessagemediaApi\Model;

/**
 * A number and its authorisation status.
 */
class Number
{
    /**
     * @var string|null The number.
     */
    public ?string $number = null;

    /**
     * @var bool|null Whether the number is authorised.
     */
    public ?bool $authorised = null;
}
