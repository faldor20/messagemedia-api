<?php

namespace Faldor20\MessagemediaApi\Model;

class SendMessagesRequest
{
    /** @var Message[] */
    public array $messages = [];

    /**
     * SendMessagesRequest constructor.
     *
     * @param Message[] $messages Array of messages to send
     */
    public function __construct(array $messages = [])
    {
        $this->messages = $messages;
    }

}
