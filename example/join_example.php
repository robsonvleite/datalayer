<?php

require 'db_config.php';
require '../vendor/autoload.php';

require 'Models/User.php';

use Example\Models\User;

/*
 * MODEL
 */
print "<h1>model</h1>";
$model = new User();
dd($model);

/**
 * FIND WITH JOIN EXAMPLE
 */
print "<h1>find with join</h1>";
$users = $model
    ->join("address", "user_id", "id")
    ->find()
    ->fetch(true);

if ($users) {
    foreach ($users as $user) {
        dd($user->data());
    }
} else {
    echo "<h2>Not Users</h2>";
}


