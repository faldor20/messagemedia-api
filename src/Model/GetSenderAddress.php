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
}
