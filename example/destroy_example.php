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
echo "<h1>Remove</h1>";

$user = (new User())->findById(6);

if ($user) {
    var_dump($user->data());
    if ($user->destroy()) {
        echo "removido";
    } else {
        var_dump($user->fail()->errorInfo);
    }
}
