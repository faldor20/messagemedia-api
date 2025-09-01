<?php

namespace Faldor20\MessagemediaApi\Model;

class SendMessagesResponse
{
    /** @var array */
    public array $messages = [];

    /**
     * SendMessagesResponse constructor.
     *
     * @param array $messages Array of message responses
     */
    public function __construct(array $messages = [])
    {
        $this->messages = $messages;
    }
}
