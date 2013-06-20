<?php

namespace Dynect\Api;

class Misc extends AbstractApi implements ApiInterface
{
    public function job($id)
    {
        return $this->get('Job/'.urlencode($id));
    }
}