<?php

require 'db_config.php';
require '../vendor/autoload.php';

require 'Models/User.php';

use Example\Models\User;

/*
 * MODEL
 */
print "model";
$model = new User();
dd($model);

/**
 * FIND WITH LEFT JOIN EXAMPLE
 */
print "<h1>find with left join</h1>";
$users = $model
    ->leftJoin("address", "user_id", "id")
    ->find()
    ->fetch(true);

if ($users) {
    foreach ($users as $user) {
        dd($user->data());
    }
} else {
    echo "<h2>Not Users</h2>";
}


