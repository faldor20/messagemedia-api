<?php

namespace Faldor20\MessagemediaApi\Model;

class PostVerificationCode
{
    public ?string $verificationCode = null;

    /**
     * PostVerificationCode constructor.
     *
     * @param string|null $verificationCode The verification code
     */
    public function __construct(?string $verificationCode = null)
    {
        $this->verificationCode = $verificationCode;
    }
}
