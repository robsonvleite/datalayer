<?php

define("CONF_DB_HOST", "localhost");
define("CONF_DB_NAME", "datalayer_example");
define("CONF_DB_USER", "root");
define("CONF_DB_PASS", "");

require '../vendor/autoload.php';

use CoffeeCode\DataLayer\Connect;

$connect = Connect::getInstance();
$error = Connect::getError();

if ($error) {
    echo $error->getMessage();
    exit;
}

$users = $connect->query("SELECT * FROM users LIMIT 5");
var_dump($users->fetchAll());