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

print "<h1>findById</h1>";
$user = $model->findById(55);
dd($user);

/**
 * FIND EXAMPLE
 */

print "<h1>count</h1>";
$model = new User();
echo $model->find()->count();

print "<h1>find</h1>";
$model = new User();
$users = $model->find()->fetch(true);
//$users = $model->find()->group("genre")->fetch(true);
//$users = $model->find()->limit(2)->fetch(true);
//$users = $model->find()->limit(2)->offset(2)->fetch(true);
//$users = $model->find()->limit(2)->offset(2)->order("first_name ASC")->fetch(true);

if ($users) {
    foreach ($users as $user) {
        dd($user->data());
    }
} else {
    echo "<h2>Not Users</h2>";
}

print "<h1>get</h1>";
$model = new User();
$user = $model->where("id", "=", 53)->get();

if ($user) {
    dd($user->data());
} else {
    echo "<h2>Not User</h2>";
}

print "<h1>get all</h1>";
$model = new User();
$users = $model->get(true);

if ($users) {
    foreach ($users as $user) {
        dd($user->data());
    }
} else {
    echo "<h2>Not Users</h2>";
}

