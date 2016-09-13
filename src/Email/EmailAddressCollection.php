<?php

namespace RHorv\ValueObjects\Email;

use Traversable;

/**
 * Class EmailAddressCollection
 * @package RHorv\Mailer\Core\Domain
 */
class EmailAddressCollection implements \Countable, \IteratorAggregate
{
    /**
     * @var array
     */
    private $list = [];

    /**
     * EmailAddressCollection constructor.
     * @param array $list
     */
    public function __construct(array $list = array())
    {
        foreach ($list as $email) {
            $this->add(new EmailAddress($email));
        }
    }

    /**
     * @param EmailAddress $email
     */
    public function add(EmailAddress $email)
    {
        if (!$this->contains($email)) {
            $this->list[] = $email;
        }
    }

    /**
     * @param EmailAddressCollection $collection
     */
    public function addCollection(EmailAddressCollection $collection)
    {
        foreach ($collection->getIterator() as $email) {
            $this->add($email);
        }
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->list);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->list);
    }

    /**
     * @param EmailAddress $otherEmail
     * @return bool
     */
    public function contains(EmailAddress $otherEmail)
    {
        /** @var EmailAddress $email */
        foreach ($this->list as $email) {
            if ($email->equals($otherEmail)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $emailArray = [];
        /** @var EmailAddress $item */
        foreach ($this->list as $item) {
            $emailArray[] = $item->getFullAddress();
        }
        return implode(",", $emailArray);
    }

}