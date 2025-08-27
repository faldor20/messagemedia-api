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
}
