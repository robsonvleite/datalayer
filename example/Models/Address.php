<?php

namespace Example\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class Address
 * @package Example\Models
 */
class Address extends DataLayer
{
    /**
     * Address constructor.
     */
    public function __construct()
    {
        parent::__construct("address", [], 'address_id');
    }
}