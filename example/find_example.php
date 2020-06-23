<?php

require 'db_config.php';
require '../vendor/autoload.php';

require 'Models/User.php';
require 'Models/Address.php';

use Example\Models\User;

/*
 * MODEL
 */
print "model";
$model = new User();
var_dump($model);

print "findById";
$user = $model->findById(20);
var_dump($user->data());

/**
 * FIND EXAMPLE
 */
print "find";
//$users = $model->find()->fetch(true);
//$users = $model->find()->group("genre")->fetch(true);
//$users = $model->find()->limit(2)->fetch(true);
//$users = $model->find()->limit(2)->offset(2)->fetch(true);
//$users = $model->find()->limit(2)->offset(2)->fetch("last_name DESC");
//$users = $model->find()->limit(2)->offset(2)->order("RAND()")->fetch(true);

$users = $model->find()->limit(1)->fetch(true);
$totalUsers = $model->find()->count();
var_dump($totalUsers);

if ($users) {
    foreach ($users as $user) {
        var_dump($user->data());
    }
} else {
    echo "<h2>Not Users</h2>";
}