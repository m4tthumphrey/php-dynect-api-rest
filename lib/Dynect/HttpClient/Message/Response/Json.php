<?php

namespace Dynect\HttpClient\Message\Response;

use Dynect\HttpClient\Message\Response;

class Json extends Response
{
    /**
     * {@inheritDoc}
     */
    public function getContent()
    {
        $response = parent::getContent();
        $content  = json_decode($response, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            return $response;
        }

        if ($content['status'] == 'success') {
            return $content['data'];
        }

        return $content;
    }
}
