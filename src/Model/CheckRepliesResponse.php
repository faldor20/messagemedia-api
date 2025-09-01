<?php

namespace Faldor20\MessagemediaApi\Model;

/**
 * A response containing replies to a message.
 */
class CheckRepliesResponse
{
    /** @var Reply[] */
    public array $replies = [];

    /**
     * @param array $replies
     */
    public function __construct(array $replies) {
    	$this->replies = $replies;
    }
}
