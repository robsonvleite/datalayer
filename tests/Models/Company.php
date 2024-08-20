<?php

namespace CoffeeCode\DataLayer\Tests\Models;

use CoffeeCode\DataLayer\DataLayer;

class Company extends DataLayer
{
    public function __construct($database = null)
    {
        parent::__construct('companies', ['user_id', 'name'], 'id', true, $database);
    }
}
