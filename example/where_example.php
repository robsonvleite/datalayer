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
$result = $user->where("users.id", '=', '1')
                ->orWhere("email", "=", "willian28@email.com.br")
                ->orWhere("email", "=", "eleno29@email.com.br")
                ->join("address")
                ->on("users.id", "=", "address.user_id")
                ->limit(1)
                ->column("users.email, users.first_name, address.street, address.number, posts.title")
                ->join("posts")
                ->on("users.id", "=", "posts.author")
                ->get(true);


var_dump($user->query);

foreach($result as $user){
    var_dump($user->data());
}




