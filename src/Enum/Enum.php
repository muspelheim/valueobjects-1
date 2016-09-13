<?php

namespace RHorv\ValueObjects\Enum;

abstract class Enum
{

    /**
     * @return array
     */
    static public function getAllowedValues()
    {
        return (new \ReflectionClass(new static()))->getConstants();
    }

    /**
     * @param $value
     *
     * @return bool
     */
    final public function isAllowedValue($value)
    {
        return in_array($value, self::getAllowedValues(), true);
    }

    /**
     * @param $value
     * @return bool
     */
    abstract public function is($value);

    /**
     * @param $value
     * @return bool
     */
    final public function isNot($value)
    {
        return !$this->is($value);
    }

    /**
     * @param Enum $other
     * @return bool
     */
    abstract function equals(Enum $other);
}