<?php

namespace Thing;

class BestRateFinder
{
    /**
     * @var Equipment
     */
    private $equipment;

    /**
     * @param Equipment $equipment
     */
    public function __construct(Equipment $equipment)
    {
        $this->equipment = $equipment;
    }

    public function findForRange(DateRange $range)
    {
        return $this->equipment->getBaseRate();
    }
}
