<?php

namespace RHorv\ValueObjects\Money;

use RHorv\ValueObjects\Currency\Currency;

class Money
{
    /**
     * @var int
     */
    protected $amount;
    /**
     * @var Currency
     */
    protected $currency;

    /**
     * @param $amount
     * @param Currency $currency
     */
    public function __construct($amount, Currency $currency)
    {
        if (!is_int($amount)) {
            throw new \InvalidArgumentException(sprintf("'%s' is not a valid amount", $amount));
        }

        $this->amount = $amount;
        $this->currency = $currency;
    }

    /**
     * @param $methodName
     * @param array $params
     * @return static
     */
    public static function __callStatic($methodName, array $params)
    {
        return new static($params[0], new Currency($methodName));
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param Money $other
     * @return bool
     */
    public function equals(Money $other)
    {
        return $other->getAmount() === $this->amount && $other->getCurrency()->equals($this->currency);
    }

    /**
     * @param Money $money
     * @return int
     */
    private function compare(Money $money)
    {
        if (!$this->currency->equals($money->getCurrency())) {
            throw new \InvalidArgumentException("Currencies do not match");
        }

        if ($this->amount === $money->getAmount()) {
            return 0;
        } else {
            return $this->amount < $money->getAmount() ? -1 : 1;
        }
    }

    /**
     * @param Money $money
     * @return bool
     */
    public function isMoreThan(Money $money)
    {
        return $this->compare($money) === 1;
    }

    /**
     * @param Money $money
     * @return bool
     */
    public function isLessThan(Money $money)
    {
        return $this->compare($money) === -1;
    }

    /**
     * @param Money $money
     * @return static
     */
    public function add(Money $money)
    {
        if (!$this->currency->equals($money->getCurrency())) {
            throw new \InvalidArgumentException("Currencies do not match");
        }

        return new static($this->amount + $money->getAmount(), $this->currency);
    }

    /**
     * @param Money $money
     * @return static
     */
    public function subtract(Money $money)
    {
        if (!$this->currency->equals($money->getCurrency())) {
            throw new \InvalidArgumentException("Currencies do not match");
        }

        return new static($this->amount - $money->getAmount(), $this->currency);
    }

    public function __toString()
    {
        return sprintf("%s %s.%s", $this->currency,
            substr($this->amount, 0, strlen($this->amount) - $this->currency->getExponent()),
                substr($this->amount, -1 * $this->currency->getExponent()));
    }
}