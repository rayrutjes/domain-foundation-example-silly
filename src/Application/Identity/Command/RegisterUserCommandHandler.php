<?php

namespace RayRutjes\DomainFoundation\Example\Application\Identity\Command;

use RayRutjes\DomainFoundation\Command\Command;
use RayRutjes\DomainFoundation\Command\Handler\CommandHandler;
use RayRutjes\DomainFoundation\Example\Domain\Identity\Password;
use RayRutjes\DomainFoundation\Example\Domain\Identity\RegisterUserService;
use RayRutjes\DomainFoundation\Example\Domain\Identity\User;
use RayRutjes\DomainFoundation\Example\Domain\Identity\Username;
use RayRutjes\DomainFoundation\Example\Domain\Identity\UserRepository;

final class RegisterUserCommandHandler implements CommandHandler
{
    /**
     * @var RegisterUserService
     */
    private $registerUserService;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param RegisterUserService $registerUserService
     * @param UserRepository      $userRepository
     */
    public function __construct(RegisterUserService $registerUserService, UserRepository $userRepository)
    {
        $this->registerUserService = $registerUserService;
        $this->userRepository = $userRepository;
    }

    /**
     * @param RegisterUserCommand $command
     *
     * @return User
     */
    protected function handleRegisterUser(RegisterUserCommand $command)
    {
        $username = new Username($command->username());
        $password = new Password($command->password());

        $user = $this->registerUserService->registerUser($username, $password);

        $this->userRepository->add($user);

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

        if($payload instanceof RegisterUserCommand) {
            $this->handleRegisterUser($payload);
        }
    }
}
