<?php

namespace RayRutjes\DomainFoundation\Example\Domain\Identity;

/**
 * A hashed representation of a password. This does not implement the ValueObject
 * Interface as the equality check could require some third party tool.
 */
final class HashedPassword
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $hashedPassword
     */
    public function __construct($hashedPassword)
    {
        if (!is_string($hashedPassword)) {
            throw new \InvalidArgumentException('Hashed Password should be a string.');
        }
        $this->value = $hashedPassword;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->value;
    }
}
