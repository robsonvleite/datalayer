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
        parent::__construct("users", ["first_name", "last_name"]);
    }

    /**
     * @param bool $obj
     * @return User
     */
    public function address(bool $obj = false): User
    {
        $this->relational_fields[] = 'address';

        if ($obj) {
            $this->address = (new Address())->findByUser($this->id);
            return $this;
        }

        $address = (new Address())->findByUser($this->id);
        if (empty($address)) {
            $this->address = null;
        } else {
            $this->address = (new Address())->findByUser($this->id)->data();
        }
        return $this;
    }

    /**
     * @param bool $obj
     * @return User
     */
    public function socials(bool $obj = false): User
    {
        $this->relational_fields[] = 'socials';
        $socials = (new Socials())->getUserSocials($this->id);

        if ($obj) {
            $this->socials = $socials;
            return $this;
        }

        if (empty($socials)) {
            $this->socials = null;
            return $this;
        }

        foreach ($socials as $key => $value) {
            $user_socials[] = $value->data();
        }
        $this->socials = $user_socials;
        return $this;
    }
}