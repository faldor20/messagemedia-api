<?php

namespace Faldor20\MessagemediaApi\Model;

/**
 * A response to checking if one or several numbers are currently blacklisted.
 */
class CheckIfOneOrSeveralNumbersAreCurrentlyBlacklistedResponse
{
    /**
     * @var string|null
     */
    public ?string $uri = null;

    /**
     * @var Number[]
     */
    public array $numbers = [];
}
