<?php

namespace RayRutjes\DomainFoundation\Example\Domain\Identity;

use RayRutjes\DomainFoundation\Serializer\Serializable;

final class UserRegistered implements Serializable
{
    /**
     * @var string
     */
    private $userIdentifier;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $hashedPassword;

    /**
     * @var string
     */
    private $at;

    /**
     * @param UserIdentifier $userIdentifier
     * @param Username       $username
     * @param HashedPassword $hashedPassword
     * @param \DateTime      $at
     */
    public function __construct(UserIdentifier $userIdentifier, Username $username, HashedPassword $hashedPassword, \DateTime $at)
    {
        $this->userIdentifier = $userIdentifier->toString();
        $this->username = $username->toString();
        $this->at = $at->format('UTC');
        $this->hashedPassword = $hashedPassword->toString();
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
    public function username()
    {
        return new Username($this->username);
    }

    /**
     * @return HashedPassword
     */
    public function hashedPassword()
    {
        return new HashedPassword($this->hashedPassword);
    }

    /**
     * @return DateTime
     */
    public function at()
    {
        return new \DateTime($this->at);
    }
}
