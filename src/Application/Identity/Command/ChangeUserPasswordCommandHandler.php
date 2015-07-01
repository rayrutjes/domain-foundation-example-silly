<?php

namespace RayRutjes\DomainFoundation\Example\Application\Identity\Command;

use RayRutjes\DomainFoundation\Command\Command;
use RayRutjes\DomainFoundation\Command\Handler\CommandHandler;
use RayRutjes\DomainFoundation\Example\Domain\Identity\Password;
use RayRutjes\DomainFoundation\Example\Domain\Identity\PasswordHashingService;
use RayRutjes\DomainFoundation\Example\Domain\Identity\UserIdentifier;
use RayRutjes\DomainFoundation\Example\Domain\Identity\UserRepository;

final class ChangeUserPasswordCommandHandler implements CommandHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var PasswordHashingService
     */
    private $passwordHashingService;

    /**
     * @param UserRepository         $userRepository
     * @param PasswordHashingService $passwordHashingService
     */
    public function __construct(UserRepository $userRepository, PasswordHashingService $passwordHashingService)
    {
        $this->userRepository = $userRepository;
        $this->passwordHashingService = $passwordHashingService;
    }

    /**
     * @param ChangeUserPasswordCommand $command
     *
     * @return User
     */
    protected function handleChangeUserPassword(ChangeUserPasswordCommand $command)
    {
        $userIdentifier = new UserIdentifier($command->userIdentifier());
        $newPassword = new Password($command->newPassword());

        $hashedPassword = $this->passwordHashingService->hashPassword($newPassword);

        $user = $this->userRepository->load($userIdentifier);
        $user->changePassword($hashedPassword);

        return $user;
    }

    /**
     * @param Command $command
     *
     * @return mixed
     */
    public function handle(Command $command)
    {
        $payload = $command->payload();

        if($payload instanceof ChangeUserPasswordCommand) {
            $this->handleChangeUserPassword($payload);
        }
    }
}
