<?php

namespace Faldor20\MessagemediaApi\Model;

use Faldor20\MessagemediaApi\Enum\SenderAddressType;
use Faldor20\MessagemediaApi\Enum\UsageType;

class ReVerifySenderAddressRequestItem
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
     * ReVerifySenderAddressRequestItem constructor.
     *
     * @param string|null $id The ID
     * @param string|null $senderAddress The sender address
     * @param SenderAddressType|string|null $senderAddressType The sender address type (enum instance or string)
     * @param UsageType|string|null $usageType The usage type (enum instance or string)
     * @param array|null $destinationCountries List of destination countries
     * @param string|null $reason The reason for the request
     * @param string|null $label A reference label
     * @param string|null $status The status
     * @param string|null $accountId The account ID
     * @param string|null $createdDate The creation date
     * @param string|null $lastModifiedDate The last modified date
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
