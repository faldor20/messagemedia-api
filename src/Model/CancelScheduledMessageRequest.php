<?php

namespace Faldor20\MessagemediaApi\Model;

class CancelScheduledMessageRequest implements \JsonSerializable
{
    public string $status = 'cancelled';

 
    public function __construct() {
 
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'status' => $this->status,
        ];
    }
}
