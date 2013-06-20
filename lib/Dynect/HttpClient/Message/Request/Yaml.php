<?php

namespace Dynect\HttpClient\Message\Request;

use Dynect\HttpClient\Message\Request;
use Dynect\Exception\RuntimeException;

class Yaml extends Request
{
    final public function __construct($method = self::METHOD_GET, $resource = '/', $host = null)
    {
        throw new RuntimeException('Yaml requests are not yet supported in this client');
    }
}
