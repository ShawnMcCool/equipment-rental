<?php

namespace Thing;

class Equipment
{
    private $name;
    /**
     * @var Rate
     */
    private $baseRate;
    private $rates = [];

    public function __construct($name, Rate $baseRate)
    {
        $this->name = $name;
        $this->baseRate = $baseRate;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getBaseRate()
    {
        return $this->baseRate;
    }

    public function addRate(DateRange $dateRange = null, Price $price, $unitInDays)
    {
        $this->rates[] = new Rate($dateRange, $price, $unitInDays);
    }

    public function getRates()
    {
        return $this->rates;
    }
}
