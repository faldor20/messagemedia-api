<?php

namespace Faldor20\MessagemediaApi\Model;

class SendMessagesRequest implements \JsonSerializable
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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'messages' => $this->messages,
        ];
    }
}
