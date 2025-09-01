<?php

namespace Faldor20\MessagemediaApi\Model;

use Faldor20\MessagemediaApi\Enum\SenderAddressType;
use Faldor20\MessagemediaApi\Enum\UsageType;

class AlphaTagRequestItem
{
    public ?string $id = null;
    public ?string $senderAddress = null;
    public ?SenderAddressType $senderAddressType = null;
    public ?UsageType $usageType = null;
    public ?array $destinationCountries = null;
    public ?string $reason = null;
    public ?string $label = null;
    public ?string $status = null;
    public ?string $accountId = null;
    public ?string $createdDate = null;
    public ?string $lastModifiedDate = null;

    /**
     * AlphaTagRequestItem constructor.
     *
     * @param string|null $id
     * @param string|null $senderAddress
     * @param SenderAddressType|string|null $senderAddressType
     * @param UsageType|string|null $usageType
     * @param array|null $destinationCountries
     * @param string|null $reason
     * @param string|null $label
     * @param string|null $status
     * @param string|null $accountId
     * @param string|null $createdDate
     * @param string|null $lastModifiedDate
     */
    public function __construct(
        ?string $id = null,
        ?string $senderAddress = null,
        $senderAddressType = null,
        $usageType = null,
        ?array $destinationCountries = null,
        ?string $reason = null,
        ?string $label = null,
        ?string $status = null,
        ?string $accountId = null,
        ?string $createdDate = null,
        ?string $lastModifiedDate = null
    ) {
        $this->id = $id;
        $this->senderAddress = $senderAddress;
        $this->senderAddressType = $this->normalizeEnum($senderAddressType, SenderAddressType::class);
        $this->usageType = $this->normalizeEnum($usageType, UsageType::class);
        $this->destinationCountries = $destinationCountries;
        $this->reason = $reason;
        $this->label = $label;
        $this->status = $status;
        $this->accountId = $accountId;
        $this->createdDate = $createdDate;
        $this->lastModifiedDate = $lastModifiedDate;
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
