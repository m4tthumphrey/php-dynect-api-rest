<?php

namespace Dynect\HttpClient\Message\Request;

use Dynect\HttpClient\Message\Request;
use Dynect\Exception\RuntimeException;

class Xml extends Request
{
    final public function __construct($method = self::METHOD_GET, $resource = '/', $host = null)
    {
        throw new RuntimeException('XML requests are not yet supported in this client');
    }
}
