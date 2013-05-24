php-dynect-api-rest
===================

PHP wrapper for v2 of the Dynect API. This is very much a work in progress, do not use in production.

Usage
-----

```php
try {
    $client = new Dynect\Client();
    $response = $client->api('session')->login('company_name', 'username', 'password');

    print_r($response);

    /*
    Array
    (
        [token] => ...
        [version] => 3.4.0
    )
    */
} catch (Exception $e) {
    echo '<h1>Error!</h1><p>'.$e->getMessage().'</p>';
}
```