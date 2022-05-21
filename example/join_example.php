<?php

require 'db_config.php';
require '../vendor/autoload.php';

require 'Models/User.php';

use Example\Models\User;

/*
 * INNER JOIN
 */
$users = (new User())
    ->find(null, null, 'users.*, addresses.city')
    ->join('addresses', 'addresses.user_id', '=', 'users.id')
    ->fetch(true);

if ($users) {
    var_dump($users);
}

/*
 * LEFT/RIGHT JOIN
 */
$users = (new User())
    ->find(null, null, 'users.*, addresses.city')
    ->join('addresses', 'addresses.user_id', '=', 'users.id', 'left')
    ->fetch(true);

if ($users) {
    var_dump($users);
}

/*
 * WHERE
 */
$users = (new User())
    ->find(null, null, 'users.*, addresses.city')
    ->join('addresses', 'addresses.user_id', '=', 'users.id', 'inner',
        'addresses.city IS NOT NULL ')
    ->fetch(true);

if ($users) {
    var_dump($users);
}