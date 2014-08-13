<?php

namespace Rental;

final class RentalPeriod
{
    /**
     * @var \DateTime
     */
    private $startDate;
    /**
     * @var \DateTime
     */
    private $endDate;

    public function __construct() {}

    public static function fromDateTime(\DateTime $startDate, \DateTime $endDate)
    {
        $range = new static;
        $range->startDate = $startDate;
        $range->endDate = $endDate;
        return $range;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function equals(RentalPeriod $other)
    {
        return $this->startDate->getTimestamp() == $other->startDate->getTimestamp() &&
            $this->endDate->getTimestamp() == $other->endDate->getTimestamp() &&
            $this->startDate->getTimezone() == $other->startDate->getTimezone() &&
            $this->endDate->getTimezone() == $other->endDate->getTimezone();
    }

    public function isWithinRange(\DateTime $date)
    {
        return $date->getTimestamp() >= $this->startDate->getTimestamp() &&
            $date->getTimestamp() <= $this->endDate->getTimestamp();
    }

    public function overlapsWithRange(RentalPeriod $other)
    {
        return $this->otherRangeBoundariesFallWithinThisRange($other) ||
        $this->theseRangeBoundariesFallWithinOtherRange($other);
    }

    /**
     * @param RentalPeriod $other
     * @return bool
     */
    private function otherRangeBoundariesFallWithinThisRange(RentalPeriod $other)
    {
        return $this->isWithinRange($other->getStartDate()) || $this->isWithinRange($other->getEndDate());
    }

    private function theseRangeBoundariesFallWithinOtherRange($other)
    {
        return $other->isWithinRange($this->startDate) || $other->isWithinRange($this->endDate);
    }

    public function getDayCount()
    {
        return $this->startDate->diff($this->endDate)->format("%a") + 1;
    }
}
