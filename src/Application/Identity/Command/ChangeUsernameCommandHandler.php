<?php

namespace RayRutjes\DomainFoundation\Example\Application\Identity\Command;

use RayRutjes\DomainFoundation\Command\Command;
use RayRutjes\DomainFoundation\Command\Handler\CommandHandler;
use RayRutjes\DomainFoundation\Example\Domain\Identity\UserIdentifier;
use RayRutjes\DomainFoundation\Example\Domain\Identity\Username;
use RayRutjes\DomainFoundation\Example\Domain\Identity\UserRepository;

final class ChangeUsernameCommandHandler implements CommandHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param ChangeUsernameCommand $command
     *
     * @return User
     */
    protected function handleChangeUsername(ChangeUsernameCommand $command)
    {
        $userIdentifier = new UserIdentifier($command->userIdentifier());
        $newUsername = new Username($command->newUsername());

        $user = $this->userRepository->load($userIdentifier);
        $user->changeUsername($newUsername);

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

        if($payload instanceof ChangeUsernameCommand) {
            $this->handleChangeUsername($payload);
        }
    }
}
