<?php

namespace RayRutjes\DomainFoundation\Example\Application\Identity\Command;

use RayRutjes\DomainFoundation\Serializer\Serializable;

final class RegisterUserCommand implements Serializable
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @param string $username
     * @param string $password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function username()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function password()
    {
        return $this->password;
    }
}
