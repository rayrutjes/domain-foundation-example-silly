<?php

namespace RayRutjes\DomainFoundation\Example\Domain\Identity;

use RayRutjes\DomainFoundation\Domain\AggregateRoot\AggregateRootIdentifier;
use RayRutjes\DomainFoundation\ValueObject\Identity\Uuid;

final class UserIdentifier implements AggregateRootIdentifier
{
    /**
     * @var Uuid
     */
    private $uuid;

    /**
     * @param string|Uuid $uuid
     */
    public function __construct($uuid)
    {
        $this->uuid = $uuid instanceof Uuid ? $uuid : new Uuid($uuid);
    }

    /**
     * @return UserIdentifier
     */
    public static function generate()
    {
        return new self(Uuid::generate());
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->uuid->toString();
    }

    /**
     * @param UserIdentifier $identifier
     *
     * @return bool
     */
    public function equals(AggregateRootIdentifier $identifier)
    {
        if(!$identifier instanceof $this) {
            return false;
        }
        return $this->toString() === $identifier->toString();
    }
}
