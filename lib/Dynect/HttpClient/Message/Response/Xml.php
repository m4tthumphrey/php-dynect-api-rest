<?php

namespace Dynect\HttpClient\Message\Response;

use Dynect\HttpClient\Message\Response;
use Dynect\Exception\RuntimeException;

class Xml extends Response
{
    final public function __construct()
    {
        throw new RuntimeException('XML responses are not yet supported in this client');
    }
}
