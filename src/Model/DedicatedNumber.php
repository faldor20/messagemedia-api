<?php

namespace Faldor20\MessagemediaApi\Model;

use Faldor20\MessagemediaApi\Enum\Capability;
use Faldor20\MessagemediaApi\Enum\Classification;
use Faldor20\MessagemediaApi\Enum\NumberType;

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
     * @var NumberType|null The type of the number.
     */
    public ?NumberType $type = null;

    /**
     * DedicatedNumber constructor.
     *
     * @param string|null $availableAfter The date and time after which the number is available
     * @param Capability[] $capabilities The capabilities of the number
     * @param Classification|null $classification The classification of the number 
     * @param string|null $country The country of the number
     * @param string|null $id The ID of the number
     * @param string|null $phoneNumber The phone number
     * @param NumberType|null $type The type of the number 
     */
    public function __construct(
        ?string $availableAfter = null,
        array $capabilities = [],
        ?Classification $classification = null,
        ?string $country = null,
        ?string $id = null,
        ?string $phoneNumber = null,
        ?NumberType $type = null
    ) {
        $this->availableAfter = $availableAfter;
        $this->capabilities = $capabilities;
        $this->classification = $this->normalizeEnum($classification, Classification::class);
        $this->country = $country;
        $this->id = $id;
        $this->phoneNumber = $phoneNumber;
        $this->type = $this->normalizeEnum($type, NumberType::class);
    }

    /**
     * Normalize enum value - accepts either enum instance or string and returns enum instance
     *
     * @param mixed $value
     * @param string $enumClass
     * @return mixed|null
     */
    private function normalizeEnum($value, string $enumClass)
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof $enumClass) {
            return $value;
        }

        if (is_string($value)) {
            return $enumClass::from($value);
        }

        throw new \InvalidArgumentException("Invalid value for {$enumClass}: " . var_export($value, true));
    }
}
