<?php

namespace RayRutjes\DomainFoundation\Example\Application\Identity\Command;

use RayRutjes\DomainFoundation\Serializer\Serializable;

final class ChangeUsernameCommand implements Serializable
{
    /**
     * @var string
     */
    private $userIdentifier;

    /**
     * @var string
     */
    private $newUsername;

    /**
     * @param $userIdentifier
     * @param $newUsername
     */
    public function __construct($userIdentifier, $newUsername)
    {
        $this->userIdentifier = $userIdentifier;
        $this->newUsername = $newUsername;
    }

    /**
     * @return string
     */
    public function userIdentifier()
    {
        return $this->userIdentifier;
    }

    /**
     * @return string
     */
    public function newUsername()
    {
        return $this->newUsername;
    }
}
