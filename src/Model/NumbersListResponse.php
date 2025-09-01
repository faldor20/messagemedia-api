<?php

namespace Faldor20\MessagemediaApi\Model;

/**
 * A response containing a list of dedicated numbers.
 */
class NumbersListResponse
{
    /** @var DedicatedNumber[] */
    public array $data = [];

    /**
     * @var array|null The pagination information.
     */
    public ?array $pagination = null;

    /**
     * NumbersListResponse constructor.
     *
     * @param DedicatedNumber[] $data Array of dedicated numbers
     * @param array|null $pagination The pagination information
     */
    public function __construct(array $data = [], ?array $pagination = null)
    {
        $this->data = $data;
        $this->pagination = $pagination;
    }
}
