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
    const DRIVE_SQLSERVER = 'sqlsrv';
    const DRIVE_ORACLE = 'oci';
    
    /** @var array */
    private static array $instance;

    /** @var PDOException|null */
    private static ?PDOException $error = null;

    /**
     * @param array|null $database
     * @return PDO|null
     */
    public static function getInstance(array $database = null): ?PDO
    {
        $dbConf = ($database ?? DATA_LAYER_CONFIG);
        $dbName = "{$dbConf["driver"]}-{$dbConf["dbname"]}@{$dbConf["host"]}";
        
        if (empty(self::$instance[$dbName])) {
            try {
                if ($dbConf["driver"] === self::DRIVE_SQLSERVER) {
                    // SQL Server
                    self::$instance[$dbName] = new PDO(
                        $dbConf["driver"] . ":Server=" . $dbConf["host"] . "," . $dbConf["port"] . ";Database=" . $dbConf["dbname"],
                        $dbConf["username"],
                        $dbConf["passwd"],
                        $dbConf["options"]
                    );
                } elseif ($dbConf["driver"] === self::DRIVE_ORACLE) {
                    // Oracle
                    $tns = '(DESCRIPTION =
                                (ADDRESS_LIST =
                                    (ADDRESS = (PROTOCOL = TCP)(HOST = ' . $dbConf["host"] . ')(PORT = ' . $dbConf["port"] . '))
                                )
                                (CONNECT_DATA =
                                    (SERVICE_NAME = ' . $dbConf["dbname"] . ')
                                )
                            )';

                    self::$instance[$dbName] = new PDO(
                        "oci:dbname=" . $tns . ";charset=UTF8",
                        $dbConf["username"],
                        $dbConf["passwd"],
                        $dbConf["options"]
                    );
                } else {
                    // Outros
                    self::$instance[$dbName] = new PDO(
                        $dbConf["driver"] . ":host=" . $dbConf["host"] . ";dbname=" . $dbConf["dbname"] . ";port=" . $dbConf["port"],
                        $dbConf["username"],
                        $dbConf["passwd"],
                        $dbConf["options"]
                    );
                }
            } catch (PDOException $exception) {
                self::$error = $exception;
                return null;
            }
        }
                
        return self::$instance[$dbName];
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
