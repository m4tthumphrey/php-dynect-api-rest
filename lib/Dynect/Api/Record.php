<?php

namespace Dynect\Api;

use Dynect\Exception\InvalidArgumentException;

class Record extends AbstractApi implements ApiInterface
{
    private function getRecordType($type)
    {
        return urlencode($type).'Record';
    }
    
    public function remove($record_type, $zone, $fqdn, $record_id)
    {
        return $this->delete($this->getRecordType($record_type).'/'.urlencode($zone).'/'.urlencode($fqdn).'/'.urlencode($record_id));
    }

    public function records($record_type, $zone, $fqdn, $record_id = null)
    {
        $path = $this->getRecordType($record_type).'/'.urlencode($zone).'/'.urlencode($fqdn);

        if (null !== $record_id) {
            $path .= '/'.urlencode($record_id);
        }

        return $this->get($path);
    }

    public function create($record_type, $zone, $fqdn, array $rdata, $ttl = 0)
    {
        if (false === stristr($fqdn, $zone)) {
            $fqdn = $fqdn.'.'.$zone;
        }

        return $this->post($this->getRecordType($record_type).'/'.urlencode($zone).'/'.urlencode($fqdn), array(
            'rdata' => $rdata,
            'ttl' => $ttl
        ));
    }

    public function update($record_type, $zone, $fqdn, array $rdata, $record_id = null, $ttl = 0)
    {
        $path = $this->getRecordType($record_type).'/'.urlencode($zone).'/'.urlencode($fqdn);

        if (null !== $record_id) {
            $path .= '/'.urlencode($record_id);
        }

        return $this->put($path, array(
            'rdata' => $rdata,
            'ttl' => $ttl
        ));
    }

    public function updateMultiple($record_type, $zone, $fqdn, array $records)
    {
        foreach ($records as $record) {
            if (!isset($record['rdata'])) {
                throw new InvalidArgumentException('Missing rdata');
            }
        }

        $key = $record_type.'s';

        return $this->put($this->getRecordType($record_type).'/'.urlencode($zone).'/'.urlencode($fqdn), array(
            $key => $records
        ));
    }

}