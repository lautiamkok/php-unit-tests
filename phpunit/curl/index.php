<?php

// Including global autoloader
require_once __DIR__ . '/vendor/autoload.php';

$Curl = new Foo\Curl();

echo $Curl->fetch();
