<?php

require 'db_config.php';
require '../vendor/autoload.php';

require 'Models/User.php';
require 'Models/Address.php';

use Example\Models\Address;
use Example\Models\User;

/*
 * USER REMOVE
 */
print "<h1>user remove</h1>";

$users = (new User())->find("id > :id", "id=55")->fetch(true);

if ($users) {
    foreach ($users as $user) {
        $user->destroy();
    }
}

/**
 * ADDR REMOVE
 */
print "<hr><h1>addr remove</h1>";

$addrs = (new Address())->find("address_id > :id", "id=1")->fetch(true);

if ($addrs) {
    foreach ($addrs as $addr) {
        $addr->destroy();
    }
}