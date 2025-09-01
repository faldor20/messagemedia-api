<?php

namespace Faldor20\MessagemediaApi\Model;

/**
 * The account used to submit the original message.
 */
class VendorAccountId
{
    /**
     * @var string The vendor identifier.
     */
    public string $vendorId;

    /**
     * @var string The account used to submit the original message.
     */
    public string $accountId;

    /**
     * VendorAccountId constructor.
     *
     * @param string $vendorId The vendor identifier
     * @param string $accountId The account used to submit the original message
     */
    public function __construct(
        string $vendorId,
        string $accountId
    ) {
        $this->vendorId = $vendorId;
        $this->accountId = $accountId;
    }
}
