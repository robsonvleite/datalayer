<?php

require 'db_config.php';
require '../vendor/autoload.php';

require 'Models/User.php';
require 'Models/Address.php';

use Example\Models\Address;
use Example\Models\User;

/*
 * USER MODEL
 */

echo "<h1>Where:</h1>";
$user = new User();
$result = $user->columns("first_name")
                ->select()
                ->where("id", '=', '2')
                ->get();

var_dump($result);




