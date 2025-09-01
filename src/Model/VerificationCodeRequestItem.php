<?php

namespace Faldor20\MessagemediaApi\Model;

use Faldor20\MessagemediaApi\Enum\SenderAddressType;
use Faldor20\MessagemediaApi\Enum\UsageType;

class VerificationCodeRequestItem
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
     * VerificationCodeRequestItem constructor.
     *
     * @param string|null $id The ID
     * @param string|null $senderAddress The sender address
     * @param SenderAddressType|null $senderAddressType The sender address type (enum instance or string)
     * @param UsageType|null $usageType The usage type (enum instance or string)
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
        ?SenderAddressType $senderAddressType = null,
        ?UsageType $usageType = null,
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
        $this->senderAddressType = $senderAddressType;
        $this->usageType = $usageType;
        $this->destinationCountries = $destinationCountries;
        $this->reason = $reason;
        $this->label = $label;
        $this->status = $status;
        $this->accountId = $accountId;
        $this->createdDate = $createdDate;
        $this->lastModifiedDate = $lastModifiedDate;
    }


}
