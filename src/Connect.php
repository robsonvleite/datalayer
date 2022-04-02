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
    private static PDO $instance;

    /** @var PDOException|null */
    private static ?PDOException $error = null;

    /**
     * @param array|null $database
     * @return PDO|null
     */
    public static function getInstance(?array $database = null): ?PDO
    {
        if (empty(self::$instance) || $database != DATA_LAYER_CONFIG) {
            $db = $database ?? DATA_LAYER_CONFIG;
            try {
                self::$instance = new PDO(
                    $db["driver"] . ":host=" . $db["host"] . ";dbname=" . $db["dbname"] . ";port=" . $db["port"],
                    $db["username"],
                    $db["passwd"],
                    $db["options"]
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
    private function __construct()
    {
    }

    /**
     * Connect clone.
     */
    private function __clone()
    {
    }
}
