<?php

namespace Dynect\Model;

use Dynect\Client;
use Dynect\Exception\RuntimeException;

abstract class AbstractModel
{
    protected $_client = null;

    public function getClient()
    {
        return $this->_client;
    }

    public function setClient(Client $client = null)
    {
        if (null !== $client) {
            $this->_client = $client;
        }

        return $this;
    }

    public function api($api)
    {
        return $this->getClient()->api($api);
    }

    public function hydrate(array $data = array())
    {
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $this->$k = $v;
            }
        }

        return $this;
    }

}