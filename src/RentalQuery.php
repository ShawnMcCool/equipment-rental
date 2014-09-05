<?php namespace Rental;

class RentalQuery
{
    /**
     * @var Equipment
     */
    private $equipment;
    /**
     * @var RentalPeriod
     */
    private $period;

    public function __construct(Equipment $equipment, RentalPeriod $period)
    {
        $this->equipment = $equipment;
        $this->period = $period;
    }

    public function getRentalPeriod()
    {
        return $this->period;
    }

    public function getEquipment()
    {
        return $this->equipment;
    }

    public function getRates()
    {
        return $this->equipment->getRates();
    }

    public function getApplicableRates()
    {
        return array_filter($this->getRates(), function($rate) {
            return $rate->overlapsWithPeriod($this->period);
        });
    }

    public function getTotalDayCount()
    {
        return $this->period->getDayCount();
    }
}
