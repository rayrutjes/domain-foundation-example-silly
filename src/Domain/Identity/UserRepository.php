<?php

namespace RayRutjes\DomainFoundation\Example\Domain\Identity;

interface UserRepository
{
    /**
     * @param User $user
     */
    public function add(User $user);

    /**
     * @param UserIdentifier $userIdentifier
     * @param null           $expectedVersion
     *
     * @return User
     */
    public function load(UserIdentifier $userIdentifier, $expectedVersion = null);
}
