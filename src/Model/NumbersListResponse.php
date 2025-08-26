<?php

namespace Schoolzine\MessagemediaApi\Model;

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
}
