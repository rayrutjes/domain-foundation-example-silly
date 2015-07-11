<?php 

namespace RayRutjes\DomainFoundation\Example\Application\Identity\Projection;

use RayRutjes\DomainFoundation\Domain\Event\Event;
use RayRutjes\DomainFoundation\EventBus\EventListener;
use RayRutjes\DomainFoundation\Example\Domain\Identity\ChangedUsername;
use RayRutjes\DomainFoundation\Example\Domain\Identity\UserIdentifier;
use RayRutjes\DomainFoundation\Example\Domain\Identity\Username;
use RayRutjes\DomainFoundation\Example\Domain\Identity\UserRegistered;

class ClaimedUsernamesProjection implements EventListener
{
    /**
     * @var \PDO
     */
    private $pdo;
    
    /**
     * @var string
     */
    private $tableName;

    /**
     * @param \PDO   $pdo
     * @param string $tableName
     */
    public function __construct(\PDO $pdo, $tableName = 'claimed_usernames')
    {
        $this->pdo = $pdo;
        $this->tableName = $tableName;
    }

    /**
     * @param Event $event
     *
     * @return mixed
     */
    public function handle(Event $event)
    {
        $payload = $event->payload();
        if ($payload instanceof UserRegistered) {
            $this->handleUserRegistration($payload);
        } elseif ($payload instanceof ChangedUsername) {
            $this->handleUsernameChange($payload);
        }
    }

    /**
     * @param UserRegistered $event
     */
    public function handleUserRegistration(UserRegistered $event)
    {
        $this->insertUsername($event->userIdentifier(), $event->username());
    }

    /**
     * @param ChangedUsername $event
     */
    public function handleUsernameChange(ChangedUsername $event)
    {
        $this->updateUsername($event->userIdentifier(), $event->newUsername());
    }

    /**
     * @param UserIdentifier $userIdentifier
     * @param Username       $username
     */
    private function insertUsername(UserIdentifier $userIdentifier, Username $username)
    {
        $sql = 'INSERT INTO ' . $this->tableName . ' (user_id, username) VALUES (:user_id, :username)';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':user_id', $userIdentifier->toString());
        $statement->bindValue(':username', $username->toString());
        $statement->execute();
    }

    /**
     * @param UserIdentifier $userIdentifier
     * @param Username       $username
     */
    private function updateUsername(UserIdentifier $userIdentifier, Username $username)
    {
        $sql = 'UPDATE ' . $this->tableName . ' SET username = :username WHERE user_id = :user_id';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':user_id', $userIdentifier->toString());
        $statement->bindValue(':username', $username->toString());
        $statement->execute();
    }
}
