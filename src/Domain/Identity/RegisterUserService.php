<?php

namespace RayRutjes\DomainFoundation\Example\Domain\Identity;

final class RegisterUserService
{
    /**
     * @var PasswordHashingService
     */
    private $passwordHashingService;

    /**
     * @param PasswordHashingService $passwordHashingService
     */
    public function __construct(PasswordHashingService $passwordHashingService)
    {
        $this->passwordHashingService = $passwordHashingService;
    }

    /**
     * @param Username $username
     * @param Password $password
     *
     * @return User
     */
    public function registerUser(Username $username, Password $password)
    {
        $hashedPassword = $this->passwordHashingService->hashPassword($password);

        return User::register(UserIdentifier::generate(), $username, $hashedPassword);
    }
}
