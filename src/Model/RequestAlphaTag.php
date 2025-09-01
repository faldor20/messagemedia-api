<?php

namespace Faldor20\MessagemediaApi\Model;

use Faldor20\MessagemediaApi\Enum\SenderAddressType;
use Faldor20\MessagemediaApi\Enum\UsageType;

class RequestAlphaTag
{
    public ?string $senderAddress = null;
    public SenderAddressType $senderAddressType;
    public UsageType $usageType;
    public ?array $destinationCountries = null;
    public ?string $reason = null;
    public ?string $label = null;

    /**
     * RequestAlphaTag constructor.
     *
     * @param string|null $senderAddress The sender address
     * @param SenderAddressType|string $senderAddressType The sender address type (enum instance or string)
     * @param UsageType|string $usageType The usage type (enum instance or string)
     * @param array|null $destinationCountries List of destination countries
     * @param string|null $reason The reason for the request
     * @param string|null $label A reference label
     */
    public function __construct(
        ?string $senderAddress = null,
        $senderAddressType = null,
        $usageType = null,
        ?array $destinationCountries = null,
        ?string $reason = null,
        ?string $label = null
    ) {
        $this->senderAddress = $senderAddress;
        $this->senderAddressType = $this->normalizeEnum($senderAddressType, SenderAddressType::class) ?? SenderAddressType::ALPHANUMERIC();
        $this->usageType = $this->normalizeEnum($usageType, UsageType::class) ?? UsageType::ALPHANUMERIC();
        $this->destinationCountries = $destinationCountries;
        $this->reason = $reason;
        $this->label = $label;
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
