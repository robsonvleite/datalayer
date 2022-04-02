<?php

namespace Example\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class User
 * @package Example\Models
 */
class UserDatabase extends DataLayer
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct("ws_users", ["user_name", "user_lastname"], "user_id", false, DATABASE);
    }
}