<?php

namespace Schoolzine\MessagemediaApi\Model;

use Schoolzine\MessagemediaApi\Enum\SenderAddressType;
use Schoolzine\MessagemediaApi\Enum\UsageType;

class RequestAlphaTag
{
    public ?string $senderAddress = null;
    public SenderAddressType $senderAddressType = SenderAddressType::ALPHANUMERIC;
    public UsageType $usageType = UsageType::ALPHANUMERIC;
    public ?array $destinationCountries = null;
    public ?string $reason = null;
    public ?string $label = null;
}
