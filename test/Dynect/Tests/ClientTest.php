<?php

namespace Dynect\Tests;

use Dynect\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldNotHaveToPassHttpClientToConstructor()
    {
        $client = new Client();

        $this->assertInstanceOf('Dynect\HttpClient\HttpClient', $client->getHttpClient());
    }
}