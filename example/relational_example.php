<?php

require 'db_config.php';
require '../vendor/autoload.php';

require 'Models/User.php';
require 'Models/Address.php';
require 'Models/Socials.php';

use Example\Models\User;

$model = new User();

print "relational fields";
$user = $model->findById(6);
if (!empty($user)) {
    $user = $user->socials()->address();
}
var_dump($user);

$user = $model->findById(1);
if (!empty($user)) {
    $user = $user->socials()->address();
}
var_dump($user);