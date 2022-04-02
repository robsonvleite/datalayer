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
$create = false;
if ($create) {
    echo "<h1>Create:</h1>";

    $user = new User;
    $user->first_name = "Robson";
    $user->last_name = "V. Leite";
    $user->genre = "m";
    if ($user->save()) {
        echo "Usuário cadastrado";
        var_dump($user->data());
    } else {
        echo "<b>Erro ao cadastrar:</b> {$user->fail()->getMessage()}";
        var_dump($user->fail());
    }

    die;
}

/*
 * UPDATE USER
 */
$update = false;
if ($update) {
    echo "<h1>Update:</h1>";

    $name = ["Marcos", "Marcelo", "Ricardo", "João"];
    $user = (new User())->findById(4);

    if ($user) {
        $user->first_name = $name[rand(0, 3)];
        if ($user->save()) {
            echo "Usuário atualizado";
            var_dump($user->data());
        } else {
            echo "<b>Erro ao atualizar:</b> {$user->fail()->getMessage()}";
            var_dump($user->fail());
        }
    } else {
        echo "<p>Usuário não encontrado, informe o id do usuário!</p>";
    }

    die;
}

/*
 * ADDR MODEL
 */
$addr = false;
if ($addr) {
    echo "<h1>Addr Model Example</h1>";

    $user = (new User())->findById(5);

    $addr = new Address;
    $addr->user_id = $user->id;
    $addr->address = "Rua do {$user->first_name}, Nº " . rand(1, 1000);

    if ($addr->save()) {
        echo "Endereço atualizado!";
        var_dump($addr->data());
        var_dump($addr->getUser()->data());
    } else {
        echo "<h2>{$addr->fail()->getMessage()}</h2>";
        var_dump($addr->fail());
        die;
    }

    die;
}