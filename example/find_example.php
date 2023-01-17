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
$testId = 1;

echo "<h1>User Model</h1>";
$user = new User();
var_dump($user);

echo "<h1>Find By Id</h1>";
$user = (new User())->findById($testId);
var_dump($user->data(), [$user->first_name, $user->full_name]);

/**
 * FIND EXAMPLE
 */
echo "<h1>Find</h1>";
//$result = $user->find()->fetch(true);
//$result = $user->find()->group("genre")->fetch(true);
//$result = $user->find()->limit(4)->fetch(true);
//$result = $user->find()->limit(2)->offset(2)->fetch(true);
//$result = $user->find()->limit(4)->offset(2)->order("id DESC")->fetch(true);
//$result = $user->find()->limit(2)->offset(2)->order("RAND()")->fetch(true);

$result = $user->find()->limit(1)->fetch(true);
$totalUsers = $user->find()->count();
echo "<h2>{$totalUsers} cadastros!</h2>";

if ($result) {
    foreach ($result as $user) {
        var_dump($user->data());
    }
} else {
    echo "<h2>Not Users</h2>";
}

echo "<h1>Find IN</h1>";
$result = $user->find()->in("id", [1, 2, 3])->fetch(true);

if ($result) {
    foreach ($result as $user) {
        var_dump($user->data());
    }
} else {
    echo "<h2>Not Users</h2>";
}


echo "<h1>Secure Params</h1>";
$params = http_build_query(["name" => "UpInside"]);
$company = (new Company())->find("name = :name", $params);
var_dump($company->fetch()->data());


echo "<h1>Join</h1>";

$addresses = new Address();
$address = $addresses->findById($testId);
$address->getUser();

var_dump($address->data());

echo "<h1>Table Columns</h1>";

var_dump($user->columns()); //object
var_dump($user->columns(PDO::FETCH_COLUMN));