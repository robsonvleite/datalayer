<?php

define("DATA_LAYER_CONFIG", [
    "driver" => "mysql",
    "host" => "mysql",
    //"port" => "3006",
    "dbname" => "rodify",
    "username" => "root",
    "passwd" => "root",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);

//define("DATA_LAYER_CONFIG", [
//    "driver" => "pgsql",
//    "host" => "localhost",
//    "port" => "5432",
//    "dbname" => "datalayer",
//    "username" => "postgres",
//    "passwd" => "",
//    "options" => [
//        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
//        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
//        PDO::ATTR_CASE => PDO::CASE_NATURAL
//    ],
//]);
function dd($data, $exit = false)
{
    echo '<pre style="font-size:11px;">';

    if (is_array($data) || is_object($data)) {
        echo htmlentities(print_r($data, true));
    } elseif (is_string($data)) {
        echo "string(" . strlen($data) . ") \"" . htmlentities($data) . "\"\n";
    } else {
        dd($data);
    }

    echo "\n</pre>";

    if ($exit) {
        exit;
    }
}