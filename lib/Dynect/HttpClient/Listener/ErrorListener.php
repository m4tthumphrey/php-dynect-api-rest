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
        /** @var $response \Gitlab\HttpClient\Message\Response */
        if ($response->isClientError() || $response->isServerError()) {
            $content = $response->getContent();
            if (is_array($content) && isset($content['message'])) {
                if (400 == $response->getStatusCode()) {
                    throw new ErrorException($content['message'], 400);
                } elseif (422 == $response->getStatusCode() && isset($content['errors'])) {
                    debug ($content);
                }
            }

            throw new RuntimeException(isset($content['message']) ? $content['message'] : $content, $response->getStatusCode());
        }
    }
}
