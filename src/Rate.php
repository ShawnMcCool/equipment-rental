<?php namespace Rental;

class Rate
{
    /**
     * @var RentalPeriod
     */
    private $dateRange;
    /**
     * @var Price
     */
    private $price;
    private $unitInDays;

    public function __construct(RentalPeriod $dateRange = null, Price $price, $unitInDays)
    {
        $this->dateRange = $dateRange;
        $this->price = $price;
        $this->unitInDays = $unitInDays;
    }

    /**
     * @param RentalPeriod $range
     * @return bool
     */
    public function appliesToDateRange(RentalPeriod $range)
    {
        if ( ! $this->dateRange) {
            return true;
        }
        return $this->dateRange->overlapsWithRange($range);
    }

    public function getUnitDays()
    {
        return $this->dateRange ? $this->dateRange->getDayCount() : 1;
    }

    /**
     * @return mixed
     */
    public function getUnitPrice()
    {
        return Price::fromString($this->price->getValue() / $this->unitInDays, $this->price->getCurrency());
    }

    public function getPrice()
    {
        return $this->price;
    }
}
