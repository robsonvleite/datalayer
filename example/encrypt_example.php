<?php

require 'db_config.php';
require '../vendor/autoload.php';

require 'Models/User.php';

use Example\Models\User;

/*
 * CREATE USER
 */
$create = true;
if ($create) {
    $user = new User();
    $user->first_name   = 'Wilder';
    $user->last_name    = 'Amorim';
    $user->document     = '123.456.789-10';

    if ($user->save()) {
        echo 'Usuário cadastrado';
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
    if ($user = (new User())->findById(1)) {
        $user->document     = '111.222.333-44';

        if ($user->save()) {
            echo 'Usuário atualizado';
            var_dump($user->data());
        } else {
            echo "<b>Erro ao atualizar:</b> {$user->fail()->getMessage()}";
            var_dump($user->fail());
        }
    } else {
        echo '<p>Usuário não encontrado, informe o id do usuário!</p>';
    }

    die;
}

/*
 * READ USER
 */
$read = false;
if ($read) {
    if ($user = (new User())->find('id = :id', 'id=1')->fetch()) {
        var_dump($user->data());
    } else {
        echo "<p>Usuário não encontrado, informe o id do usuário!</p>";
    }

    die;
}
