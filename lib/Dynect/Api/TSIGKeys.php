<?php

namespace Dynect\Api;

class TSIGKeys extends AbstractApi implements ApiInterface
{
    public function all()
    {
        return $this->get('TSIGKey');
    }

    public function info($name)
    {
        return $this->get('TSIGKey/'.urlencode($name));
    }

    public function create($name, $secret)
    {
        return $this->post('TSIGKey/'.urlencode($name), array(
            'secret' => $secret
        ));
    }

    public function update($name, array $params)
    {
        return $this->put('TSIGKey/'.urlencode($name), $params);
    }

    public function remove($name)
    {
        return $this->delete('TSIGKey/'.urlencode($name));
    }
}