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
                ->join("address")
                ->on("users.id", "=", "address.user_id")
                ->limit(2)
                ->column("users.email, users.first_name, address.street, address.number, posts.title")
                ->join("posts")
                ->on("users.id", "=", "posts.author")
                ->get(true);


var_dump($user->query);

foreach($result as $user){
    var_dump($user->data());
}




