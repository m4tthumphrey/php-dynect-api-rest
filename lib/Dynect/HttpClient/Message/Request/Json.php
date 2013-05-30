<?php

namespace Dynect\HttpClient\Message\Request;

use Dynect\HttpClient\Message\Request;

class Json extends Request
{
    public function setContent($content)
    {
        if ($content) {
            parse_str($content, $array);
            $json = json_encode($array);

            parent::setContent($json);
        }
    }
}
