<?php

namespace Faldor20\MessagemediaApi\Model;

/**
 * A request to add one or more numbers to your blacklist.
 */
class AddOneOrMoreNumbersToYourBlacklistRequest
{
    /** @var string[] */
    public array $numbers = [];

    /**
     * @param array $numbers
     */
    public function __construct(array $numbers) {
    	$this->numbers = $numbers;
    }
}
