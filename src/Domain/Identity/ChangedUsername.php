<?php

namespace RayRutjes\DomainFoundation\Example\Domain\Identity;

use RayRutjes\DomainFoundation\Serializer\Serializable;

final class ChangedUsername implements Serializable
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
     * @param UserIdentifier $userIdentifier
     * @param Username       $newUsername
     * @param \DateTime      $at
     */
    public function __construct(UserIdentifier $userIdentifier, Username $newUsername, \DateTime $at)
    {
        $this->userIdentifier = $userIdentifier->toString();
        $this->newUsername = $newUsername->toString();
        $this->at = $at->format('UTC');
    }

    /**
     * @return UserIdentifier
     */
    public function userIdentifier()
    {
        return new UserIdentifier($this->userIdentifier);
    }

    /**
     * @return Username
     */
    public function newUsername()
    {
        return new Username($this->newUsername);
    }

    /**
     * @return DateTime
     */
    public function at()
    {
        return new \DateTime($this->at);
    }
}
