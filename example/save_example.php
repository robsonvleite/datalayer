<?php

require 'db_config.php';
require '../vendor/autoload.php';

require 'Models/User.php';
require 'Models/Address.php';

use Example\Models\Address;
use Example\Models\User;


print "new user model";

$user = new User;
$user->first_name = "Robson";
$user->last_name = "V. Leite";
$user->genre = "m";
$user->save();

var_dump($user);

print "update user";

$name = ["Robson", "Kaue", "Gustavo", "João"];

$user = (new User())->findById(10000);

if ($user) {
    $user->first_name = $name[rand(0, 3)];
    $user->save();
    var_dump($user);
}else{
    echo "<h2>Not User</h2>";
}

print "addr model (primary changed)";

$addr = new Address;
$addr->address = "Rua Nome Da Rua 001";
$addr->save();

var_dump($addr);
