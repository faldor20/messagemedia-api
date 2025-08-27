<?php

namespace Faldor20\MessagemediaApi\Model;

use Faldor20\MessagemediaApi\Enum\Capability;
use Faldor20\MessagemediaApi\Enum\Classification;
use Faldor20\MessagemediaApi\Enum\Type;

/**
 * A dedicated number.
 */
class DedicatedNumber
{
    /**
     * @var string|null The date and time after which the number is available.
     */
    public ?string $availableAfter = null;

    /**
     * @var Capability[] The capabilities of the number.
     */
    public array $capabilities = [];

    /**
     * @var Classification|null The classification of the number.
     */
    public ?Classification $classification = null;

    /**
     * @var string|null The country of the number.
     */
    public ?string $country = null;

    /**
     * @var string|null The ID of the number.
     */
    public ?string $id = null;

    /**
     * @var string|null The phone number.
     */
    public ?string $phoneNumber = null;

    /**
     * @var Type|null The type of the number.
     */
    public ?Type $type = null;
}
