<?php
require_once '../vendor/autoload.php';

use DX\Models\SessionKey;

$sk = new SessionKey(93019994, 99, 955698);
//$sk = new SessionKey(93019994, 99, 955690);
print_r($sk);