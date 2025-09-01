<?php

namespace Faldor20\MessagemediaApi\Model;

/**
 * A request to confirm replies as received.
 */
class ConfirmRepliesAsReceivedRequest implements \JsonSerializable
{
    /** @var string[] */
    public array $replyIds = [];

    /**
     * @param array $replyIds
     */
    public function __construct(array $replyIds) {
    	$this->replyIds = $replyIds;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'reply_ids' => $this->replyIds,
        ];
    }
}
