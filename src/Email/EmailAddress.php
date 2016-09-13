<?php

namespace RHorv\ValueObjects\Email;

class EmailAddress
{

    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $host;

    /**
     * @param string $email
     */
    public function __construct($email)
    {
        $this->validateEmailAddress($email);
        $emailParts = explode("@", $email);
        $this->identifier = $emailParts[0];
        $this->host = $emailParts[1];
    }

    /**
     * @param $email
     */
    private function validateEmailAddress($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new \InvalidArgumentException(sprintf("Invalid email address '%s'", $email));
        }
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function getFullAddress()
    {
        return sprintf("%s@%s", $this->getIdentifier(), $this->getHost());
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getFullAddress();
    }

    /**
     * @param $other
     * @return bool
     */
    public function equals($other)
    {
        return get_class($this) === get_class($other) && $this->getIdentifier() === $other->getIdentifier() && $this->getHost() === $other->getHost();
    }
}