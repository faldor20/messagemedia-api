<?php

namespace Faldor20\MessagemediaApi\Model;

class GetAllApprovedSenderAddresses
{
    /** @var GetSenderAddress[] */
    public array $data = [];
    public ?array $pagination = null;

    /**
     * GetAllApprovedSenderAddresses constructor.
     *
     * @param GetSenderAddress[] $data Array of sender addresses
     * @param array|null $pagination Pagination information
     */
    public function __construct(array $data = [], ?array $pagination = null)
    {
        $this->data = $data;
        $this->pagination = $pagination;
    }
}
