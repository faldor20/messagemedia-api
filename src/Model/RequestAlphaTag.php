<?php

namespace Faldor20\MessagemediaApi\Model;

use Faldor20\MessagemediaApi\Enum\SenderAddressType;
use Faldor20\MessagemediaApi\Enum\UsageType;

class RequestAlphaTag
{
    public ?string $senderAddress = null;
    public SenderAddressType $senderAddressType = SenderAddressType::ALPHANUMERIC;
    public UsageType $usageType = UsageType::ALPHANUMERIC;
    public ?array $destinationCountries = null;
    public ?string $reason = null;
    public ?string $label = null;
}
