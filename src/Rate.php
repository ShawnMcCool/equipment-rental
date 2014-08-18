<?php namespace Rental;

class Rate
{
    /**
     * @var RentalPeriod
     */
    private $rentalPeriod;
    /**
     * @var Price
     */
    private $price;
    private $unitInDays;

    public function __construct(RentalPeriod $rentalPeriod = null, Price $price, $unitInDays)
    {
        $this->rentalPeriod = $rentalPeriod;
        $this->price = $price;
        $this->unitInDays = $unitInDays;
    }

    /**
     * @param RentalPeriod $range
     * @return bool
     */
    public function overlapsWithPeriod(RentalPeriod $range)
    {
        if ( ! $this->rentalPeriod) {
            return true;
        }
        return $this->rentalPeriod->overlapsWithRange($range);
    }

    public function getUnitDays()
    {
        return $this->unitInDays;
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

    public function getPriceForDays($days)
    {
        return $this->getUnitPrice()->times($days);
    }
}
