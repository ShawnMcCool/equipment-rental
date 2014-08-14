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
}
