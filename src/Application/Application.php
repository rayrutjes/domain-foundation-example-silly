<?php

namespace RayRutjes\DomainFoundation\Example\Application;

use RayRutjes\DomainFoundation\Command\Bus\SimpleCommandBus;
use RayRutjes\DomainFoundation\Command\Gateway\CommandGateway;
use RayRutjes\DomainFoundation\Command\Gateway\DefaultCommandGateway;
use RayRutjes\DomainFoundation\Command\Handler\Registry\CommandHandlerRegistry;
use RayRutjes\DomainFoundation\Command\Handler\Registry\InMemoryCommandHandlerRegistry;
use RayRutjes\DomainFoundation\EventBus\SimpleEventBus;
use RayRutjes\DomainFoundation\Example\Application\Identity\Command\ChangeUsernameCommand;
use RayRutjes\DomainFoundation\Example\Application\Identity\Command\ChangeUsernameCommandHandler;
use RayRutjes\DomainFoundation\Example\Application\Identity\Command\ChangeUserPasswordCommand;
use RayRutjes\DomainFoundation\Example\Application\Identity\Command\ChangeUserPasswordCommandHandler;
use RayRutjes\DomainFoundation\Example\Application\Identity\Command\RegisterUserCommand;
use RayRutjes\DomainFoundation\Example\Application\Identity\Command\RegisterUserCommandHandler;
use RayRutjes\DomainFoundation\Example\Application\Identity\Projection\ClaimedUsernamesProjection;
use RayRutjes\DomainFoundation\Example\Domain\Identity\RegisterUserService;
use RayRutjes\DomainFoundation\Example\Infrastructure\Identity\BcryptPasswordHashingService;
use RayRutjes\DomainFoundation\Example\Infrastructure\Persistence\PdoUserRepository;
use RayRutjes\DomainFoundation\Persistence\Pdo\EventStore\PdoEventStore;
use RayRutjes\DomainFoundation\Persistence\Pdo\UnitOfWork\PdoTransactionManager;
use RayRutjes\DomainFoundation\UnitOfWork\DefaultUnitOfWork;
use RayRutjes\DomainFoundation\UnitOfWork\UnitOfWork;

final class Application
{
    /**
     * @var Application
     */
    private static $instance;

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var CommandHandlerRegistry
     */
    private $commandHandlerRegistry;

    /**
     * @var CommandGateway
     */
    private $commandGateway;

    /**
     * @var UnitOfWork
     */
    private $unitOfWork;

    /**
     * Even though the use of singleton pattern is kind of controversial,
     * I couldn't find a better use case than this one.
     *
     * @return Application
     */
    public static function instance($server, $port, $databaseName, $username, $password)
    {
        if (null === self::$instance) {
            self::$instance = new self($server, $port, $databaseName, $username, $password);
        }

        return self::$instance;
    }

    /**
     * Bootstrap the application.
     */
    private function __construct($server, $port, $databaseName, $username, $password)
    {
        $this->initializePdoConnection($server, $port, $databaseName, $username, $password);
        $this->initializeCommandGateway();
        $this->registerUserCommands();
    }

    /**
     * Create the event store table.
     */
    public function install()
    {
        $eventStore = new PdoEventStore($this->pdo);
        $eventStore->createTable();
    }

    /**
     * @return CommandGateway
     */
    public function commandGateway()
    {
        return $this->commandGateway;
    }

    private function registerUserCommands()
    {
        $simpleEventBus = new SimpleEventBus();
        $userRepository = new PdoUserRepository($this->unitOfWork, $this->pdo, $simpleEventBus);
        $passwordHashingService = new BcryptPasswordHashingService();
        $registerUserService = new RegisterUserService($passwordHashingService);

        // Register User.
        $this->commandHandlerRegistry->subscribe(
            RegisterUserCommand::class,
            new RegisterUserCommandHandler($registerUserService, $userRepository)
        );

        // Change Username.
        $this->commandHandlerRegistry->subscribe(
            ChangeUsernameCommand::class,
            new ChangeUsernameCommandHandler($userRepository)
        );

        // Change Password.
        $this->commandHandlerRegistry->subscribe(
            ChangeUserPasswordCommand::class,
            new ChangeUserPasswordCommandHandler($userRepository, $passwordHashingService)
        );

        $claimedUsernamesProjection = new ClaimedUsernamesProjection($this->pdo);
        $simpleEventBus->subscribe($claimedUsernamesProjection);
    }

    private function initializePdoConnection($server, $port, $databaseName, $username, $password)
    {
        $this->pdo = new \PDO(sprintf('mysql:host=%s;dbname=%s;port=%d', $server, $databaseName, $port), $username, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    private function initializeCommandGateway()
    {
        $transactionManager = new PdoTransactionManager($this->pdo);

        $this->commandHandlerRegistry = new InMemoryCommandHandlerRegistry();
        $this->unitOfWork = new DefaultUnitOfWork($transactionManager);

        $commandBus = new SimpleCommandBus($this->commandHandlerRegistry, $this->unitOfWork);
        $this->commandGateway = new DefaultCommandGateway($commandBus);
    }

    public function pdo()
    {
        return $this->pdo;
    }
}
