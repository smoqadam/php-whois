### PHP Whois

a class for get domain information

### Install
create a `composer.json` and put the following code in it : 

```json
{
    "require": {
        "smoqadam/php-whois": "@dev"
    }
}

```

then run `$ composer install`

### How to use

```php
 <?php

require 'src/Smoqadam/Whois.php';

$whois = new Smoqadam\Whois();

echo $whois->getDomainInfo('google.com');

if($whois->isAvailable('google.com'))
    echo 'GOOGLE.COM is available for register';
else
    echo 'GOOGLE.COM is not available for register';

```
if you want to return output as HTML just set the second parameter to `True`
```php
 <?php

require 'src/Smoqadam/Whois.php';

$whois = new Smoqadam\Whois();

echo $whois->getDomainInfo('google.com',true);
```
