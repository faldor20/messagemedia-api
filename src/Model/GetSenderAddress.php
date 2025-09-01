<?php

namespace Faldor20\MessagemediaApi\Model;

use Faldor20\MessagemediaApi\Enum\SenderAddressType;
use Faldor20\MessagemediaApi\Enum\UsageType;

/**
 * A sender address.
 */
class GetSenderAddress
{
    /**
     * @var string|null Primary ID of the record.
     */
    public ?string $id = null;

    /**
     * @var string|null The Sender Address to be requested.
     */
    public ?string $senderAddress = null;

    /**
     * @var SenderAddressType|null The Sender Address Type.
     */
    public ?SenderAddressType $senderAddressType = null;

    /**
     * @var UsageType|null The Sender Address Usage Type.
     */
    public ?UsageType $usageType = null;

    /**
     * @var array|null list of 2-character ISO country codes this sender address applies to.
     */
    public ?array $destinationCountries = null;

    /**
     * @var string|null The reason for the sender address request.
     */
    public ?string $reason = null;

    /**
     * @var string|null A reference name for the sender ID to allow you to easily track it.
     */
    public ?string $label = null;

    /**
     * @var string|null The account ID.
     */
    public ?string $accountId = null;

    /**
     * @var string|null The date the sender address was created.
     */
    public ?string $createdDate = null;

    /**
     * @var string|null The date the sender address was last modified.
     */
    public ?string $lastModifiedDate = null;

    /**
     * @var string|null The Sender Address expiration time (apply for sender_address_type = OWN_NUMBER).
     */
    public ?string $expiry = null;

    /**
     * @var string|null The Sender Address status (apply for sender_address_type = OWN_NUMBER).
     */
    public ?string $displayStatus = null;

    /**
     * GetSenderAddress constructor.
     *
     * @param string|null $id Primary ID of the record
     * @param string|null $senderAddress The Sender Address to be requested
     * @param SenderAddressType|string|null $senderAddressType The Sender Address Type (enum instance or string)
     * @param UsageType|string|null $usageType The Sender Address Usage Type (enum instance or string)
     * @param array|null $destinationCountries List of 2-character ISO country codes this sender address applies to
     * @param string|null $reason The reason for the sender address request
     * @param string|null $label A reference name for the sender ID to allow you to easily track it
     * @param string|null $accountId The account ID
     * @param string|null $createdDate The date the sender address was created
     * @param string|null $lastModifiedDate The date the sender address was last modified
     * @param string|null $expiry The Sender Address expiration time (apply for sender_address_type = OWN_NUMBER)
     * @param string|null $displayStatus The Sender Address status (apply for sender_address_type = OWN_NUMBER)
     */
    public function __construct(
        ?string $id = null,
        ?string $senderAddress = null,
        $senderAddressType = null,
        $usageType = null,
        ?array $destinationCountries = null,
        ?string $reason = null,
        ?string $label = null,
        ?string $accountId = null,
        ?string $createdDate = null,
        ?string $lastModifiedDate = null,
        ?string $expiry = null,
        ?string $displayStatus = null
    ) {
        $this->id = $id;
        $this->senderAddress = $senderAddress;
        $this->senderAddressType = $this->normalizeEnum($senderAddressType, SenderAddressType::class);
        $this->usageType = $this->normalizeEnum($usageType, UsageType::class);
        $this->destinationCountries = $destinationCountries;
        $this->reason = $reason;
        $this->label = $label;
        $this->accountId = $accountId;
        $this->createdDate = $createdDate;
        $this->lastModifiedDate = $lastModifiedDate;
        $this->expiry = $expiry;
        $this->displayStatus = $displayStatus;
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
