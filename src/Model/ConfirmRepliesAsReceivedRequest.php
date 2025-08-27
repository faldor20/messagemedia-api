<?php

namespace Faldor20\MessagemediaApi\Model;

/**
 * A request to confirm replies as received.
 */
class ConfirmRepliesAsReceivedRequest
{
    /** @var string[] */
    public array $replyIds = [];
}
