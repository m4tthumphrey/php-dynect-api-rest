<?php

namespace Dynect\Api;

use Dynect\Exception\InvalidArgumentException;

class UpdateUsers extends AbstractApi implements ApiInterface
{
    public function all()
    {
        return $this->get('UpdateUser');
    }

    public function password($username)
    {
        return $this->get('UpdateUser/'.urlencode($username));
    }

    public function create($nickname, $password)
    {
        return $this->post('UpdateUser', array(
            'nickname' => $nickname,
            'password' => $password
        ));
    }

    public function update($username, array $params)
    {
        return $this->put('UpdateUser/'.urlencode($username), $params);
    }

    public function block($username)
    {
        return $this->update($username, array(
            'block' => true
        ));
    }

    public function unblock($username)
    {
        return $this->update($username, array(
            'unblock' => true
        ));
    }

    public function changePassword($username, $password)
    {
        return $this->update($username, array(
            'password' => $password
        ));
    }

    public function remove($username)
    {
        return $this->delete('UpdateUser/'.urlencode($username));
    }

}