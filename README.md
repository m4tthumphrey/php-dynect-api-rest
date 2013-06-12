php-dynect-api-rest
===================

PHP wrapper for v2 of the Dynect API. This is very much a work in progress, do not use in production.

Installation
------------
Install Composer

```
$ curl -sS https://getcomposer.org/installer | php
$ sudo mv composer.phar /usr/local/bin/composer
```

Add the following to your require block in composer.json config:

```
"m4tthumphrey/php-dynect-api-rest": "dev-master"
```

Include Composer's autoloader:


```php
require_once dirname(__DIR__).'/vendor/autoload.php';
```

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
