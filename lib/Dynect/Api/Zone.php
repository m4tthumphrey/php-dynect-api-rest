<?php

namespace Dynect\Api;

use Dynect\Exception\InvalidArgumentException;

class Zone extends AbstractApi implements ApiInterface
{
    public function all()
    {
        return $this->get('Zone');
    }

    public function info($zone)
    {
        return $this->get('Zone/'.urlencode($zone));
    }

    public function createPrimary($zone, $admin_name, $ttl, $serial_style = null)
    {
        $params = array(
            'rname' => $admin_name,
            'ttl' => $ttl
        );

        if ($serial_style) {
            $params['serial_style'] = $serial_style;
        }

        return $this->post('Zone/'.urlencode($zone));
    }

    public function freeze($zone)
    {
        $this->put('Zone/'.urlencode($zone), array(
            'freeze' => true
        ));
    }

    public function thaw($zone)
    {
        $this->put('Zone/'.urlencode($zone), array(
            'thaw' => true
        ));
    }

    public function publish($zone)
    {
        $this->put('Zone/'.urlencode($zone), array(
            'publish' => true
        ));
    }

    public function nodes($zone, $fqdn = null)
    {
        $path = 'NodeList/'.urlencode($zone);

        if ($fqdn) {
            $path .= '/'.urlencode($fqdn);
        }

        return $this->get($path);
    }

    public function secondaries($zone)
    {
        $path = 'Secondary';

        if ($zone) {
            $path .= '/'.urlencode($zone);
        }

        return $this->get($path);
    }

    public function createSecondary($zone, $nameservers = array(), $nickname = null, $key_name = null)
    {
        return $this->post('Secondary/'.urlencode($zone), array(
            'contact_nickname' => $nickname,
            'masters' => $nameservers,
            'tsig_key_name' => $key_name
        ));
    }

    public function activateSecondary($zone)
    {
        return $this->updateSecondary($zone, array(
            'activate' => true
        ));
    }

    public function deactivateSecondary($zone)
    {
        return $this->updateSecondary($zone, array(
            'deactivate' => true
        ));
    }

    public function retransferSecondary($zone)
    {
        return $this->updateSecondary($zone, array(
            'retransfer' => true
        ));
    }

    public function updateSecondary($zone, array $params)
    {
        if (isset($params['masters']) and !is_array($params['masters'])) {
            throw new InvalidArgumentException('`masters` parameter must be an array');
        }

        return $this->put('Secondary/'.urlencode($zone), $params);
    }

    public function changes($zone)
    {
        return $this->get('ZoneChanges/'.urlencode($zone));
    }

    public function deleteChanges($zone)
    {
        return $this->delete('ZoneChanges/'.urlencode($zone));
    }

    public function remove($zone, $fqdn = null)
    {
        $zone = urlencode($zone);

        if ($fqdn) {
            return $this->delete('Node/'.$zone.'/'.urlencode($fqdn));
        }

        return $this->delete('Zone/'.$zone);
    }
}