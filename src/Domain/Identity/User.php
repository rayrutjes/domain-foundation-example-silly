<?php

namespace RayRutjes\DomainFoundation\Example\Domain\Identity;

use RayRutjes\DomainFoundation\Domain\AggregateRoot\EventSourcedAggregateRoot;

final class User extends EventSourcedAggregateRoot
{
    /**
     * @var Username
     */
    private $username;

    /**
     * @var HashedPassword
     */
    private $hashedPassword;

    /**
     * @param UserIdentifier $identifier
     * @param Username       $username
     * @param HashedPassword $hashedPassword
     *
     * @return User
     */
    public static function register(UserIdentifier $identifier, Username $username, HashedPassword $hashedPassword)
    {
        $user = new self();
        $user->applyChange(new UserRegistered($identifier, $username, $hashedPassword, new \DateTime()));

        return $user;
    }

    /**
     * @param Username $newUsername
     */
    public function changeUsername(Username $newUsername)
    {
        $this->applyChange(new ChangedUsername($this->identifier(), $newUsername, new \DateTime()));
    }

    /**
     * @param HashedPassword $newPassword
     */
    public function changePassword(HashedPassword $newPassword)
    {
        $this->applyChange(new ChangedPassword($this->identifier(), $newPassword, new \DateTime()));
    }

    /**
     * @param UserRegistered $userRegistered
     */
    public function applyUserRegistered(UserRegistered $userRegistered)
    {
        $this->setIdentifier($userRegistered->userIdentifier());
        $this->hashedPassword = $userRegistered->hashedPassword();
        $this->username = $userRegistered->username();
    }

    /**
     * @param ChangedUsername $changedUsername
     */
    public function applyChangedUsername(ChangedUsername $changedUsername)
    {
        $this->username = $changedUsername->newUsername();
    }

    /**
     * @param ChangedPassword $changedPassword
     */
    public function applyChangedPassword(ChangedPassword $changedPassword)
    {
        $this->hashedPassword = $changedPassword->newPassword();
    }
}
