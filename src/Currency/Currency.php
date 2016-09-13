<?php

namespace RHorv\ValueObjects\Currency;

/**
 * Class Currency
 * @package RHorv\ValueObjects\Currency
 */
class Currency implements Iso4217Interface
{
    /**
     * @var string
     */
    private $code;

    /**
     * Currency constructor.
     * @param $code
     */
    public function __construct($code)
    {
        if (!defined("self::" . $code)) {
            throw new \InvalidArgumentException(sprintf("'%s' is an invalid currency code", $code));
        }
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getExponent()
    {
        $currencyData = constant("self::" . $this->code);
        return $currencyData['exponent'];
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        $currencyData = constant("self::" . $this->code);
        return $currencyData['number'];
    }

    /**
     * @param Currency $other
     * @return bool
     */
    public function equals(Currency $other)
    {
        return $other->getCode() === $this->code;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->code;
    }


}