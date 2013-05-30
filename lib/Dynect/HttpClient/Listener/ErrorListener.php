<?php

namespace Dynect\HttpClient\Listener;

use Buzz\Listener\ListenerInterface;
use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;
use Dynect\Exception\ErrorException;
use Dynect\Exception\RuntimeException;
use Dynect\Exception\ValidationFailedException;

class ErrorListener implements ListenerInterface
{
    private $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * {@inheritDoc}
     */
    public function preSend(RequestInterface $request)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function postSend(RequestInterface $request, MessageInterface $response)
    {
        /** @var $response \Dynect\HttpClient\Message\Response */
        /*if ($response->isClientError() || $response->isServerError()) {
            $content = $response->getContent();
            $message = array_shift($content['msgs']);

            throw new RuntimeException($message['INFO'], $response->getStatusCode());
        }*/
    }
}
