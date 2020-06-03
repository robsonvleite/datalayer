<?php

require 'db_config.php';
require '../vendor/autoload.php';

require 'Models/User.php';

use Example\Models\User;

/**
 * FIND WITH WHERE AND WHERERAW EXAMPLE
 */
$model = new User();
print "<h1>find with where</h1>";
$users = $model
    ->where("id", ">", 53)
    ->find()
    ->fetch(true);

if ($users) {
    foreach ($users as $user) {
        dd($user->data());
    }
} else {
    echo "<h2>Not Users</h2>";
}

/**
 * FIND WITH WHERE AND WHERERAW EXAMPLE
 */
$model = new User();
print "<h1>find with whereRaw</h1>";
$users = $model
    ->whereRaw("name LIKE '%rodinei%' ")
    ->find()
    ->fetch(true);

if ($users) {
    foreach ($users as $user) {
        dd($user->data());
    }
} else {
    echo "<h2>Not Users</h2>";
}

/**
 * FIND WITH WHEREIN EXAMPLE
 */
$model = new User();
print "<h1>find with whereIn</h1>";
$users = $model
    ->whereIn("id", [53,55])
    ->find()
    ->fetch(true);

if ($users) {
    foreach ($users as $user) {
        dd($user->data());
    }
} else {
    echo "<h2>Not Users</h2>";
}


