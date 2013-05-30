<?php

namespace Dynect\HttpClient\Listener;

use Dynect\Client;
use Dynect\Exception\InvalidArgumentException;

use Buzz\Listener\ListenerInterface;
use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;
use Buzz\Util\Url;

class AuthListener implements ListenerInterface
{
    const AUTH_TOKEN_NAME = 'Auth-Token';

    private $token;

    public function __construct($token)
    {
        if (!$token) {
            throw new InvalidArgumentException('Missing token');
        }

        $this->token = $token;
    }

    public function preSend(RequestInterface $request)
    {
        $request->addHeader(sprintf('%s: %s', self::AUTH_TOKEN_NAME, $this->token));
    }

    public function postSend(RequestInterface $request, MessageInterface $response)
    {

    }
}