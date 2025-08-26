<?php

namespace Schoolzine\MessagemediaApi\Model;

use Schoolzine\MessagemediaApi\Enum\SenderAddressType;
use Schoolzine\MessagemediaApi\Enum\UsageType;

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
}
