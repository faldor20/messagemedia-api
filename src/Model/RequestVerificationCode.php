<?php

namespace Schoolzine\MessagemediaApi\Model;

use Schoolzine\MessagemediaApi\Enum\SenderAddressType;
use Schoolzine\MessagemediaApi\Enum\UsageType;

class RequestVerificationCode
{
    public ?string $senderAddress = null;
    public SenderAddressType $senderAddressType = SenderAddressType::INTERNATIONAL;
    public UsageType $usageType = UsageType::OWN_NUMBER;
    public ?array $destinationCountries = null;
    public ?string $reason = null;
    public ?string $label = null;
}
