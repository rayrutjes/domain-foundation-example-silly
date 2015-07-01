<?php

namespace RayRutjes\DomainFoundation\Example\Domain\Identity;

use RayRutjes\DomainFoundation\ValueObject\ValueObject;

final class Password implements ValueObject
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $password
     */
    public function __construct($password)
    {
        if (!is_string($password) || strlen($password) < 8) {
            throw new \InvalidArgumentException('Password should be a string containing at least 8 characters.');
        }
        $this->value = $password;
    }
    /**
     * @param ValueObject $other
     *
     * @return bool
     */
    public function sameValueAs(ValueObject $other)
    {
        if (!$other instanceof self) {
            return false;
        }

        return $this->toString() === $other->toString();
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->value;
    }
}
