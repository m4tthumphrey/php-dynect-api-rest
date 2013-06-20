<?php

namespace Dynect\Api;

class Jobs extends AbstractApi implements ApiInterface
{
    public function info($id)
    {
        return $this->get('Job/'.urlencode($id));
    }
}