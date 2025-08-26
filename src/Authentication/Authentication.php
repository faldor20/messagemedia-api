<?php

namespace Schoolzine\MessagemediaApi\Authentication;

use Psr\Http\Message\RequestInterface;

interface Authentication
{
    public function authenticate(RequestInterface $request): RequestInterface;
}
