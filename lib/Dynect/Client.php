<?php

namespace Dynect;

use Buzz\Browser;

class Client
{
    const API_URL = 'https://api2.dynect.net/REST/';

    protected $customer_name;
    protected $user_name;
    protected $password;
    protected $token;

    protected $headers;
    protected $browser;

    public function __construct($customer_name, $user_name, $password, Browser $browser = null)
    {
        $this->customer_name = $customer_name;
        $this->user_name = $user_name;
        $this->password = $password;

        if (is_null($browser)) {
            $browser = new Browser();
        }

        $this->browser = $browser;
    }

    public function checkSession()
    {
        $response = $this->get('Session');

        print_r($response);

        return false;
    }

    public function login()
    {
        if ($this->checkSession()) {
            return true;
        }

        $response = $this->post('Session', array(
            'customer_name' => $this->customer_name,
            'user_name' => $this->user_name,
            'password' => $this->password
        ));

        print_r($response);
    }

    public function get($path, $parameters = array(), $headers = array())
    {
        if (!empty($parameters)) {
            $path .= (preg_match('/?/', $path)) ? '?' : '&';
            $path .= http_build_query($parameters);
        }

        $headers = array_merge($this->headers, $headers);

        return $this->browser->get(self::API_URL.$path, $headers);
    }

    public function post($path, $parameters = array(), $headers = array())
    {
        $content = json_encode($parameters);
        $headers = array_merge($this->headers, $headers);

        return $this->browser->post(self::API_URL.$path, $headers, $content);
    }
}