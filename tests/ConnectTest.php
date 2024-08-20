<?php declare(strict_types=1);

namespace CoffeeCode\DataLayer\Tests;

use CoffeeCode\DataLayer\Connect;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Error;
use PDO;
use PDOException;

#[CoversClass(Connect::class)]
class ConnectTest extends TestCase
{
    // public function test_getinstance_function_with_data_layer_config_execption()
    // {
    //     $config = [
    //         'driver' => 'sqlsrv',
    //         'host' => 'localhost',
    //         'port' => '9999',
    //         'dbname' => 'datalayer',
    //         'username' => 'datalayer',
    //         'passwd' => 'datalayer',
    //         'options' => []
    //     ];

    //     Connect::getInstance($config);

    //     $this->assertInstanceOf(PDOException::class, Connect::getError());
    // }

    public function test_getinstance_function_with_data_layer_config_config()
    {
        $config = [
            'driver' => 'mysql',
            'host' => 'mariadb',
            'port' => '3306',
            'dbname' => 'datalayer',
            'username' => 'datalayer',
            'passwd' => 'datalayer',
            'options' => []
        ];

        $this->assertInstanceOf(PDO::class, Connect::getInstance($config));
    }

    public function test_constructor()
    {
        $this->expectException(Error::class);
        new Connect();
    }

    public function test_clone()
    {
        $this->expectException(Error::class);
        $obj = new Connect();
        $clone = clone $obj;
    }
}
