<?php

namespace RayRutjes\DomainFoundation\Example\Domain\Identity;

interface PasswordHashingService
{
    /**
     * @param Password $password
     *
     * @return HashedPassword
     */
    public function hashPassword(Password $password);

    /**
     * @param Password       $plain
     * @param HashedPassword $hashed
     *
     * @return bool
     */
    public function check(Password $plain, HashedPassword $hashed);
}
