<?php

namespace Example\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class Socials
 * @package Example\Models
 */
class Socials extends DataLayer
{
    /**
     * Socials constructor.
     */
    public function __construct()
    {
        parent::__construct("socials", ["social", "link"]);
    }

    /**
     * @param int    $user_id
     * @param string $columns
     * @return array|null
     */
    public function getUserSocials(int $user_id, string $columns = '*'): ?array
    {
        return $this->find("user_id = :id", "id={$user_id}", $columns)->fetch(true);
    }
}