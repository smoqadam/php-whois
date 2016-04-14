<?php

require 'src/Smoqadam/Whois.php';

$whois = new Smoqadam\Whois();

echo $whois->getDomainInfo('google.com');

if($whois->isAvailable('google.com'))
    echo 'GOOGLE.COM is available for register';
else
    echo 'GOOGLE.COM is not available for register';
