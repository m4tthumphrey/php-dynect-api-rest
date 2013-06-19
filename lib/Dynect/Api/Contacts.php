<?php

namespace Dynect\Api;

use Dynect\Exception\InvalidArgumentException;

class Contacts extends AbstractApi implements ApiInterface
{
    public function all()
    {
        return $this->get('Contact');
    }

    public function info($nickname)
    {
        return $this->get('Contact/'.urlencode($nickname));
    }

    public function remove($nickname)
    {
        return $this->delete('Contact/'.urlencode($nickname));
    }

    public function create($nickname, array $params)
    {
        if (!isset($params['email'])) {
            throw new InvalidArgumentException('Contact email address must be supplied');
        }

        if (!isset($params['first_name'])) {
            throw new InvalidArgumentException('Contact first name must be supplied');
        }

        if (!isset($params['last_name'])) {
            throw new InvalidArgumentException('Contact last name must be supplied');
        }

        if (!isset($params['organization'])) {
            throw new InvalidArgumentException('Contact organization must be supplied');
        }

        return $this->post('Contact/'.urlencode($nickname), $params);
    }

    public function update($nickname, array $params)
    {
        return $this->put('Contact/'.urlencode($nickname), $params);
    }

}