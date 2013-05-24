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
}