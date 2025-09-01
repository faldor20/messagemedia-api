<?php

namespace Faldor20\MessagemediaApi\Model;

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

    /**
     * Number constructor.
     *
     * @param string|null $number The number
     * @param bool|null $authorised Whether the number is authorised
     */
    public function __construct(?string $number = null, ?bool $authorised = null)
    {
        $this->number = $number;
        $this->authorised = $authorised;
    }
}
