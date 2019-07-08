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
print "user remove";

$users = (new User())->find("id > :id", "id=1")->fetch(true);

if ($users) {
    foreach ($users as $user) {
        $user->destroy();
    }
}

/**
 * ADDR REMOVE
 */
print "<hr>addr remove";

$addrs = (new Address())->find("address_id > :id", "id=1")->fetch(true);

if ($addrs) {
    foreach ($addrs as $addr) {
        $addr->destroy();
    }
}