<?php

require 'db_config.php';
require '../vendor/autoload.php';

require 'Models/User.php';
require 'Models/Address.php';
require 'Models/Company.php';

use Example\Models\Address;
use Example\Models\Company;
use Example\Models\User;

/*
 * MODEL
 */
print "model";
$model = new User();
var_dump($model);

print "findById";
$user = $model->findById(1);
var_dump($user->data());

var_dump($user->first_name);
echo "<h1>{$user->full_name}</h1>";

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

print "secure params";
$params = http_build_query(["name" => "UpInside & Associated"]);
$company = (new Company())->find("name = :name", $params);
var_dump($company, $company->fetch());


print "join method";

$addresses = new Address();
$address = $addresses->findById(1);
//get user data to this->user->[all data]
$address->user();
var_dump($address);


print "consult table columns";

//var_dump($user->columns()); //object
var_dump($user->columns(PDO::FETCH_COLUMN));