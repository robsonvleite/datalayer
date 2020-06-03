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
print "<h1>new user model</h1>";

$user = new User;
$user->first_name = "Robson";
$user->last_name = "V. Leite";
$user->genre = "m";
$user->save();

dd($user);

/*
 * UPDATE USER
 */
print "<h1>update user</h1>";

$name = ["Robson", "Kaue", "Gustavo", "João"];

$user = (new User())->findById(56);

if ($user) {
    $user->first_name = $name[rand(0, 3)];
    $user->save();
    dd($user);
} else {
    echo "<h2>Not User</h2>";
}

/*
 * ADDR MODEL PRIMARY KEY CHANGED
 */
print "<h1>addr model</h1>";

$addr = new Address;
$addr->address = "Rua Nome Da Rua 001";
$address = $addr->save();

if (!$address) {
    echo "<h2>{$addr->fail()->getMessage()}</h2>";
    dd($addr->fail());
    die;
}

dd($addr);
