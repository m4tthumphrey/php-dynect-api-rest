<?php

namespace Dynect\Model;

use Dynect\Client as Client;

class Zone extends AbstractModel
{
    public $zone;

    public function __construct(Client $client, $zone)
    {
        $this->setClient($client);
        $this->zone = $zone;
    }

    public function addRecord($type, $fqdn, array $rdata, $ttl = 0)
    {
        return $this->api('record')->create($type, $this->zone, $fqdn, $rdata, $ttl);
    }

    public function publish()
    {
        return $this->api('zone')->publish($this->zone);
    }

    public function freeze()
    {
        return $this->api('zone')->freeze($this->zone);
    }

    public function thaw()
    {
        return $this->api('zone')->thaw($this->zone);
    }

    public function changes()
    {
        return $this->api('zone')->changes($this->zone);
    }

    public function deleteChanges()
    {
        return $this->api('zone')->deleteChanges($this->zone);
    }

    public function remove($fqdn = null)
    {
        return $this->api('zone')->remove($this->zone, $fqdn);
    }
}