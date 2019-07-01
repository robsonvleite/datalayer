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

    /**
     * @param int    $user_id
     * @param string $columns
     * @return Address|null
     */
    public function findByUser(int $user_id, string $columns = '*'): ?Address
    {
        return $this->find("user_id = :id", "id={$user_id}", $columns)->fetch();
    }
}