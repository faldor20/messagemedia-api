<?php

namespace Schoolzine\MessagemediaApi\Model;

/**
 * A request to confirm replies as received.
 */
class ConfirmRepliesAsReceivedRequest
{
    /** @var string[] */
    public array $replyIds = [];
}
