<?php

namespace Dynect;

use Buzz\Client\Curl;
use Buzz\Client\ClientInterface;

use Dynect\Api\ApiInterface;
use Dynect\Exception\InvalidArgumentException;
use Dynect\HttpClient\HttpClient;
use Dynect\HttpClient\HttpClientInterface;
use Dynect\HttpClient\Listener\AuthListener;

class Client
{
    const BASE_URL = 'https://api2.dynect.net/REST/';

    protected $httpClient;
    protected $options = array();

    public function __construct($options = array(), ClientInterface $httpClient = null)
    {
        if (null === $httpClient) {
            $httpClient = new Curl();
        }

        foreach ($options as $k => $v) {
            $this->setOption($k, $v);
        }

        $this->httpClient = new HttpClient(self::BASE_URL, $this->options, $httpClient);
    }

    public function authenticate($token)
    {
        $this->getHttpClient()->authenticate($token);
    }

    public function api($api)
    {
        $api = strtolower($api);

        switch ($api) {
            case 'session':
            case 'sessions':
                return new Api\Session($this);
            default:
                throw new InvalidArgumentException('Invalid API path');
        }
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @param HttpClientInterface $httpClient
     */
    public function setHttpClient(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    /**
     * Clears used headers
     */
    public function clearHeaders()
    {
        $this->httpClient->clearHeaders();

        return $this;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->httpClient->setHeaders($headers);

        return $this;
    }

    /**
     * @param string $name
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    public function getOption($name)
    {
        if (!array_key_exists($name, $this->options)) {
            throw new InvalidArgumentException(sprintf('Undefined option called: "%s"', $name));
        }

        return $this->options[$name];
    }


    /**
     * @param string $name
     * @param mixed  $value
     *
     * @throws InvalidArgumentException
     * @throws InvalidArgumentException
     */
    public function setOption($name, $value)
    {
        if (!array_key_exists($name, $this->options)) {
            throw new InvalidArgumentException(sprintf('Undefined option called: "%s"', $name));
        }

        $this->options[$name] = $value;

        return $this;
    }
}