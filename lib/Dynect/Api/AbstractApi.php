<?php

namespace Dynect\Api;

use Dynect\Client;

abstract class AbstractApi implements ApiInterface
{
    const OPTION_YES = 'Y';
    const OPTION_NO = 'N';

    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function configure()
    {
    }

    /**
     * {@inheritDoc}
     */
    protected function get($path, array $parameters = array(), $requestHeaders = array())
    {
        $response = $this->client->getHttpClient()->get($path, $parameters, $requestHeaders);

        return $response->getContent();
    }

    /**
     * {@inheritDoc}
     */
    protected function post($path, array $parameters = array(), $requestHeaders = array())
    {
        $response = $this->client->getHttpClient()->post($path, $parameters, $requestHeaders);

        return $response->getContent();
    }

    /**
     * {@inheritDoc}
     */
    protected function patch($path, array $parameters = array(), $requestHeaders = array())
    {
        $response = $this->client->getHttpClient()->patch($path, $parameters, $requestHeaders);

        return $response->getContent();
    }

    /**
     * {@inheritDoc}
     */
    protected function put($path, array $parameters = array(), $requestHeaders = array())
    {
        $response = $this->client->getHttpClient()->put($path, $parameters, $requestHeaders);

        return $response->getContent();
    }

    /**
     * {@inheritDoc}
     */
    protected function delete($path, array $parameters = array(), $requestHeaders = array())
    {
        $response = $this->client->getHttpClient()->delete($path, $parameters, $requestHeaders);

        return $response->getContent();
    }
}
