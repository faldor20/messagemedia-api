<?php

namespace Faldor20\MessagemediaApi\Model;

use Faldor20\MessagemediaApi\Enum\SenderAddressType;
use Faldor20\MessagemediaApi\Enum\UsageType;

class RequestVerificationCode
{
    public ?string $senderAddress = null;
    public SenderAddressType $senderAddressType = SenderAddressType::INTERNATIONAL;
    public UsageType $usageType = UsageType::OWN_NUMBER;
    public ?array $destinationCountries = null;
    public ?string $reason = null;
    public ?string $label = null;
}
