<?php

namespace Dynect\Api;

use Dynect\Exception\InvalidArgumentException;

class Users extends AbstractApi implements ApiInterface
{
    public function all()
    {
        return $this->get('User');
    }

    public function info($username)
    {
        return $this->get('User/'.urlencode($username));
    }

    public function create($username, array $params)
    {
        if (!isset($params['email'])) {
            throw new InvalidArgumentException('User email address must be supplied');
        }

        if (!isset($params['first_name'])) {
            throw new InvalidArgumentException('User first name must be supplied');
        }

        if (!isset($params['last_name'])) {
            throw new InvalidArgumentException('User last name must be supplied');
        }

        if (!isset($params['nickname'])) {
            throw new InvalidArgumentException('User nickname must be supplied');
        }

        if (!isset($params['organization'])) {
            throw new InvalidArgumentException('Contact organization must be supplied');
        }

        if (!isset($params['password'])) {
            throw new InvalidArgumentException('Contact password must be supplied');
        }

        if (!isset($params['phone'])) {
            throw new InvalidArgumentException('Contact phone must be supplied');
        }

        return $this->post('User/'.urlencode($username), $params);
    }

    public function update($username, array $params)
    {
        return $this->put('User/'.urlencode($username), $params);
    }

    public function remove($username)
    {
        return $this->delete('User/'.urlencode($username));
    }
}