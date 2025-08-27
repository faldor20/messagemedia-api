<?php

namespace Faldor20\MessagemediaApi\Model;

/**
 * A response containing a list of blocked numbers.
 */
class GetNumberAuthorisationBlacklistResponse
{
    /**
     * @var string|null URL of the current API call, used to show the current pagination token for calls subsequent to the first one in the case of paginated data.
     */
    public ?string $uri = null;

    /**
     * @var string[] List of numbers belonging to the blacklist.
     */
    public array $numbers = [];

    /**
     * @var array|null The pagination information.
     */
    public ?array $pagination = null;
}
