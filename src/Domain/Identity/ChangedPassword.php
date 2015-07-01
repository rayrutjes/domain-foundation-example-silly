<?php

namespace RayRutjes\DomainFoundation\Example\Domain\Identity;

use RayRutjes\DomainFoundation\Serializer\Serializable;

final class ChangedPassword implements Serializable
{
    /**
     * @var string
     */
    private $userIdentifier;

    /**
     * @var string
     */
    private $newPassword;

    /**
     * @var string
     */
    private $at;

    /**
     * @param UserIdentifier $userIdentifier
     * @param HashedPassword $newPassword
     * @param \DateTime      $at
     */
    public function __construct(UserIdentifier $userIdentifier, HashedPassword $newPassword, \DateTime $at)
    {
        $this->userIdentifier = $userIdentifier->toString();
        $this->newPassword = $newPassword->toString();
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
     * @return HashedPassword
     */
    public function newPassword()
    {
        return new HashedPassword($this->newPassword);
    }

    /**
     * @return DateTime
     */
    public function at()
    {
        return new \DateTime($this->at);
    }
}
