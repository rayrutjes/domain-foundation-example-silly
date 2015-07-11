<?php

namespace RayRutjes\DomainFoundation\Example\Domain\Identity;

final class Username
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $username
     */
    public function __construct($username)
    {
        if (!is_string($username) || strlen($username) < 3) {
            throw new \InvalidArgumentException('Username should be a string containing at least 3 characters.');
        }
        $this->value = $username;
    }

    /**
     * @param Username $other
     *
     * @return bool
     */
    public function sameValueAs(Username $other)
    {
        return $this->toString() === $other->toString();
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}
