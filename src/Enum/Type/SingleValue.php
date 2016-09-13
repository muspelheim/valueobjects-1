<?php


namespace RHorv\ValueObjects\Enum\Type;

use RHorv\ValueObjects\Enum\Enum;

abstract class SingleValue extends Enum
{

    /**
     * @var string
     */
    protected $value;

    /**
     * @param null $value
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($value = null)
    {
        if ($value !== null && !$this->isAllowedValue($value)) {
            throw new \InvalidArgumentException(sprintf(
                "'%s' is not a valid value for this enum (Allowed values are: %s)",
                $value,
                implode(", ", static::getAllowedValues())
            ));
        }
        $this->value = $value;
    }

    /**
     * @param $value
     *
     * @return static
     */
    public function setValue($value)
    {
        return new static($value);
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getValue();
    }

    /**
     * @param $value
     * @return bool
     */
    public function is($value)
    {
        return $this->value === $value;
    }

    /**
     * @param Enum $other
     *
     * @return bool
     */
    public function equals(Enum $other)
    {
        return get_class($this) === get_class($other) && static::getAllowedValues() === $other::getAllowedValues() && $this->getValue() === $other->getValue();
    }
}