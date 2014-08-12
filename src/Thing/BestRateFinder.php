<?php

namespace Thing;

class BestRateFinder
{
    public function findForRange(Equipment $equipment, DateRange $range)
    {
        return $equipment->getBaseRate();
    }
}
