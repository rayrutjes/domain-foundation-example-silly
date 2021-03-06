<?php

namespace RayRutjes\DomainFoundation\Example\Infrastructure\Persistence;

use RayRutjes\DomainFoundation\Contract\Contract;
use RayRutjes\DomainFoundation\EventBus\EventBus;
use RayRutjes\DomainFoundation\Example\Domain\Identity\User;
use RayRutjes\DomainFoundation\Example\Domain\Identity\UserIdentifier;
use RayRutjes\DomainFoundation\Example\Domain\Identity\UserRepository;
use RayRutjes\DomainFoundation\Persistence\Pdo\EventStore\PdoEventStore;
use RayRutjes\DomainFoundation\Repository\AggregateRootRepository;
use RayRutjes\DomainFoundation\UnitOfWork\UnitOfWork;

final class PdoUserRepository implements UserRepository
{
    /**
     * @var AggregateRootRepository
     */
    private $repository;

    /**
     * @param UnitOfWork $unitOfWork
     * @param \PDO       $pdo
     * @param EventBus   $eventBus
     */
    public function __construct(UnitOfWork $unitOfWork, \PDO $pdo, EventBus $eventBus)
    {
        $eventStore = new PdoEventStore($pdo);

        $aggregateRootType = Contract::createFromClassName(User::class);

        $this->repository = new AggregateRootRepository($unitOfWork, $aggregateRootType, $eventStore, $eventBus);
    }

    /**
     * @param User $user
     */
    public function add(User $user)
    {
        $this->repository->add($user);
    }

    /**
     * @param UserIdentifier $userIdentifier
     * @param null           $expectedVersion
     *
     * @return User
     */
    public function load(UserIdentifier $userIdentifier, $expectedVersion = null)
    {
        return $this->repository->load($userIdentifier, $expectedVersion);
    }
}
