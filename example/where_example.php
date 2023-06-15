<?php

require 'db_config.php';
require '../vendor/autoload.php';

require 'Models/User.php';
require 'Models/Address.php';

use Example\Models\Address;
use Example\Models\User;

/*
 * USER MODEL
 */

echo "<h1>Where:</h1>";
$user = new User();
$result = $user 
                ->column("users.email, users.first_name")
                ->where("users.id", '=', '1')
                ->limit(5)
                ->get(true);

var_dump($user->query);

if(!empty($result)){
    foreach($result as $user){
        var_dump($user->data());
    }
}

echo "<h1>orWhere:</h1>";
$result = $user->where("users.id", '=', '1')
                ->orWhere("email", "=", "willian28@email.com.br")
                ->orWhere("email", "=", "eleno29@email.com.br")
                ->column("users.email, users.first_name")
                ->get(true);

if(!empty($result)){
    foreach($result as $user){
        var_dump($user->data());
    }
}


echo "<h1>andWhere:</h1>";
$result = $user->where("users.id", '=', '1')
                ->andWhere("email", "=", "robsonvleite@email.com.br")
                ->column("users.email, users.first_name")
                ->get(true);

if(!empty($result)){
    foreach($result as $user){
        var_dump($user->data());
    }
}







