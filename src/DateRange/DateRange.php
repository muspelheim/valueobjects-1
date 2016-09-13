<?php

namespace RHorv\ValueObjects\DateRange;

/**
 * Class DateRange
 * @package RHorv\ValueObjects\DateRange
 */
class DateRange
{
    /**
     * @var \DateTimeInterface
     */
    private $start;

    /**
     * @var \DateTimeInterface
     */
    private $end;

    /**
     * @param $start
     * @param $end
     */
    public function __construct(\DateTimeInterface $start, \DateTimeInterface $end)
    {
        if ($end->getTimestamp() < $start->getTimestamp()) {
            throw new \InvalidArgumentException("End date cannot be lower than start date");
        }
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param \DateTimeInterface $dt
     * @return bool
     */
    public function isAfter(\DateTimeInterface $dt)
    {
        return $this->start->getTimestamp() > $dt->getTimestamp();
    }

    /**
     * @param \DateTimeInterface $dt
     * @return bool
     */
    public function isBefore(\DateTimeInterface $dt)
    {
        return $this->end->getTimestamp() < $dt->getTimestamp();
    }

    /**
     * @param \DateTimeInterface $dt
     * @return bool
     */
    public function includesDate(\DateTimeInterface $dt)
    {
        return $this->start->getTimestamp() <= $dt->getTimestamp() && $this->end->getTimestamp() >= $dt->getTimestamp();
    }

    /**
     * @param DateRange $dr
     * @return bool
     */
    public function intersectsRange(DateRange $dr)
    {
        return $this->includesDate($dr->getEnd()) || $this->includesDate($dr->getStart())
            || ($this->getStart()->getTimestamp() < $dr->getStart()->getTimestamp() && $this->getEnd()->getTimestamp() > $dr->getEnd()->getTimestamp());
    }

    /**
     * @return float
     */
    public function durationInSeconds()
    {
        return $this->getEnd()->getTimestamp() - $this->getStart()->getTimestamp();
    }

    /**
     * @param DateRange $dr
     * @return DateRange
     */
    public function overlapRange(DateRange $dr)
    {
        return new static($this->getStart()->getTimestamp() < $dr->getStart()->getTimestamp() ? $dr->getStart() : $this->getStart(),
            $this->getEnd()->getTimestamp() > $dr->getEnd()->getTimestamp() ? $dr->getEnd() : $this->getEnd());
    }

    /**
     * @param $other
     * @return bool
     */
    public function equals(DateRange $other)
    {
        return $this->getStart()->getTimestamp() == $other->getStart()->getTimestamp() && $this->getEnd()->getTimestamp() == $other->getEnd()->getTimestamp();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            "%s[%d] - %s[%d]",
            $this->getStart()->format("Y-m-d H:i:s"),
            $this->getStart()->getTimestamp(),
            $this->getEnd()->format("Y-m-d H:i:s"),
            $this->getEnd()->getTimestamp()
        );
    }
}