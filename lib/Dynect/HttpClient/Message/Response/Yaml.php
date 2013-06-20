<?php

namespace Dynect\HttpClient\Message\Response;

use Dynect\HttpClient\Message\Response;
use Dynect\Exception\RuntimeException;

class Yaml extends Response
{
    final public function __construct()
    {
        throw new RuntimeException('Yaml responses are not yet supported in this client');
    }
}
