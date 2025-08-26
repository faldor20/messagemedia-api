<?php

namespace Schoolzine\MessagemediaApi\Model;

class GetAllApprovedSenderAddresses
{
    /** @var GetSenderAddress[] */
    public array $data = [];
    public ?array $pagination = null;
}
