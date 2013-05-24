<?php

namespace Dynect\Api;

class Session extends AbstractApi implements ApiInterface
{
    public function login($customer_name, $user_name, $password)
    {
        return $this->post('Session', array(
            'customer_name' => $customer_name,
            'user_name' => $user_name,
            'password' => $password
        ));
    }

    public function verify()
    {
        return $this->get('Session');
    }

    public function keepAlive()
    {
        return $this->put('Session');
    }

    public function logout()
    {
        return $this->delete('Session');
    }
}