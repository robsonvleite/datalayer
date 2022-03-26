<?php

namespace Example\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class User
 * @package Example\Models
 */
class User extends DataLayer
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct("users", ["first_name", "last_name"], "id", true, DATA_LAYER_CONFIG_2);
    }

    public function fullName()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}