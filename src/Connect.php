<?php

namespace CoffeeCode\DataLayer;

use PDO;
use PDOException;

/**
 * Class Connect
 * @package CoffeeCode\DataLayer
 */
class Connect
{
    /** @var PDO */
    private static $instance;

    /** @var PDOException */
    private static $error;

    /**
     * @return PDO
     */
    public static function getInstance($bd): ?PDO
    {
        if (empty(self::$instance)) {
            try {
                self::$instance = new PDO(
                    $bd["driver"] . ":host=" . $bd["host"] . ";dbname=" . $bd["dbname"] . ";port=" . $bd["port"],
                    $bd["username"],
                    $bd["passwd"],
                    $bd["options"]
                );
            } catch (PDOException $exception) {
                self::$error = $exception;
            }
        }

        return self::$instance;
    }


    /**
     * @return PDOException|null
     */
    public static function getError(): ?PDOException
    {
        return self::$error;
    }

    /**
     * Connect constructor.
     */
    final private function __construct()
    {
    }

    /**
     * Connect clone.
     */
    final private function __clone()
    {
    }
}