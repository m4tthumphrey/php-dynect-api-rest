<?php

namespace Dynect\HttpClient;

use Buzz\Client\ClientInterface;
use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;
use Buzz\Listener\ListenerInterface;

use Dynect\Exception\ErrorException;
use Dynect\Exception\InvalidArgumentException;
use Dynect\Exception\RuntimeException;
use Dynect\HttpClient\Listener\ErrorListener;
use Dynect\HttpClient\Message\Request;
use Dynect\HttpClient\Message\Response;

class HttpClient implements HttpClientInterface
{
    private $options = array(
        'user_agent'  => 'php-dynect-api-rest (http://github.com/m4tthumphrey/php-dynect-api-rest)',
        'timeout'     => 10,
        'content_type' => 'json'
    );

    private $contentTypes = array(
        'json' => 'application/json',
        'xml' => 'text/xml',
        'yaml' => 'application/yaml'
    );

    protected $baseUrl;
    protected $listeners = array();
    protected $headers = array();

    private $lastResponse;
    private $lastRequest;

    public function __construct($baseUrl, array $options, ClientInterface $client)
    {
        $this->baseUrl = $baseUrl;
        $this->options  = array_merge($this->options, $options);
        $this->client   = $client;

        if (!array_key_exists($this->options['content_type'], $this->contentTypes)) {
            throw new InvalidArgumentException(sprintf('Invalid content type provided: %s', $this->options['content_type']));
        }

        $this->addListener(new ErrorListener($this->options));
        $this->clearHeaders();
    }

    /**
     * {@inheritDoc}
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function setHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);
    }

    public function clearHeaders()
    {
        $this->headers = array();
    }

    public function addListener(ListenerInterface $listener)
    {
        $this->listeners[get_class($listener)] = $listener;
    }

    public function get($path, array $parameters = array(), array $headers = array())
    {
        if (0 < count($parameters)) {
            $path .= (false === strpos($path, '?') ? '?' : '&').http_build_query($parameters, '', '&');
        }

        return $this->request($path, array(), 'GET', $headers);
    }

    public function post($path, array $parameters = array(), array $headers = array())
    {
        return $this->request($path, $parameters, 'POST', $headers);
    }

    public function patch($path, array $parameters = array(), array $headers = array())
    {
        return $this->request($path, $parameters, 'PATCH', $headers);
    }

    public function delete($path, array $parameters = array(), array $headers = array())
    {
        return $this->request($path, $parameters, 'DELETE', $headers);
    }

    public function put($path, array $parameters = array(), array $headers = array())
    {
        return $this->request($path, $parameters, 'PUT', $headers);
    }

    public function request($path, array $parameters = array(), $httpMethod = 'GET', array $headers = array())
    {
        $path = trim($this->baseUrl.$path, '/');

        $request = $this->createRequest($httpMethod, $path);
        $request->addHeaders($headers);
        $request->setContent(http_build_query($parameters));

        $hasListeners = 0 < count($this->listeners);
        if ($hasListeners) {
            foreach ($this->listeners as $listener) {
                $listener->preSend($request);
            }
        }

        $response = $this->createResponse();

        try {
            $this->client->send($request, $response);
        } catch (\LogicException $e) {
            throw new ErrorException($e->getMessage());
        } catch (\RuntimeException $e) {
            throw new RuntimeException($e->getMessage());
        }

        $this->lastRequest  = $request;
        $this->lastResponse = $response;

        if ($hasListeners) {
            foreach ($this->listeners as $listener) {
                $listener->postSend($request, $response);
            }
        }

        return $response;
    }

    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    private function createRequest($httpMethod, $url)
    {
        $contentType = $this->options['content_type'];
        $this->setHeaders(sprintf('Content-type: %s', $this->contentTypes[$contentType]));

        $request = new Request($httpMethod);
        $request->setHeaders($this->headers);
        $request->fromUrl($url);

        return $request;
    }

    private function createResponse()
    {
        $class = 'Response\\'.ucfirst($this->options['content_type']);

        return new $class();
    }
}
