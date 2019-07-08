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
var_dump($model);

print "findById";
$user = $model->findById(10);
var_dump($user);

/**
 * FIND EXAMPLE
 */
print "find";
$users = $model->find()->fetch(true);
//$users = $model->find()->limit(2)->fetch(true);
//$users = $model->find()->limit(2)->offset(2)->fetch(true);
//$users = $model->find()->limit(2)->offset(2)->order("first_name ASC")->fetch(true);

$totalUsers = $model->find()->count();
var_dump($totalUsers);

if ($users) {
    foreach ($users as $user) {
        var_dump($user);
    }
} else {
    echo "<h2>Not Users</h2>";
}


