<?php

namespace Faldor20\MessagemediaApi\Model;

/**
 * A request to confirm replies as received.
 */
class ConfirmRepliesAsReceivedRequest
{
    /** @var string[] */
    public array $replyIds = [];

    /**
     * @param array $replyIds
     */
    public function __construct(array $replyIds) {
    	$this->replyIds = $replyIds;
    }

}
