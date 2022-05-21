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
     * The binary attributeS that will be encrypted.
     *
     * @var array
     */
    protected array $encrypt = [
        "document",
    ];

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct("users", ["first_name", "last_name"], "id", false);
    }

    public function fullName()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}