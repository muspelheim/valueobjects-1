<?php

namespace RHorv\ValueObjects\Enum\Type;

use RHorv\ValueObjects\Enum\Enum;

abstract class MultiValue extends Enum
{

    /**
     * @var array
     */
    protected $values;

    /**
     * @param array $values
     */
    public function __construct(array $values = null)
    {
        if ($values !== null && $this->checkAllowedValues($values)) {
            $this->values = $values;
        }
    }

    /**
     * @param array $values
     *
     * @return bool
     * @throws \InvalidArgumentException
     */
    private function checkAllowedValues(array $values)
    {
        foreach ($values as $value) {
            if (!$this->isAllowedValue($value)) {
                throw new \InvalidArgumentException(sprintf(
                    "'%s' is not a valid value for this enum (Allowed values are: %s)",
                    $value,
                    implode(", ", static::getAllowedValues())
                ));
            }
        }

        return true;
    }

    /**
     * @param $value
     *
     * @return static
     */
    public function addValue($value)
    {
        return new static(array_merge($this->getValues() ?: array(), array($value)));
    }

    /**
     * @param array $values
     *
     * @return static
     */
    public function setValues(array $values)
    {
        return new static($values);
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public function hasValue($value)
    {
        return in_array($value, $this->values);
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode(",", $this->getValues());
    }

    /**
     * @param $value
     * @return bool
     */
    public function is($value)
    {
        return in_array($value, $this->values);
    }


    /**
     * @param Enum $other
     *
     * @return bool
     */
    public function equals(Enum $other)
    {
        return get_class($this) === get_class($other) && static::getAllowedValues() === $other::getAllowedValues() && $this->getValues() === $other->getValues();
    }
}