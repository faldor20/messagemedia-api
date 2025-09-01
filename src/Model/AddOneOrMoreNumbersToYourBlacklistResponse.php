<?php

namespace Faldor20\MessagemediaApi\Model;

/**
 * A response to adding one or more numbers to your blacklist.
 */
class AddOneOrMoreNumbersToYourBlacklistResponse
{
    /**
     * @var string|null
     */
    public ?string $uri = null;

    /**
     * @var string[]
     */
    public array $numbers = [];

    /**
     * @param  $uri
     * @param array $numbers
     */
    public function __construct(?string $uri, array $numbers) {
    	$this->uri = $uri;
    	$this->numbers = $numbers;
    }
}
