<?php

namespace Rental;

class BestRateFinder
{
    public function findForRange(Equipment $equipment, RentalPeriod $range)
    {
        $rates = new RateGroup;
        $days = $range->getDayCount();

        while ($days > 0) {
            $rate = $this->getBestRateFor($equipment, $range, $days);
            $days -= $rate->getUnitDays();
            $rates->add($rate);
        }

        return $rates;
    }

    private function getBestRateFor($equipment, $range)
    {
        $bestRate = null;

        /** @var Rate $rate */
        foreach ($equipment->getRates() as $rate) {
            if ($rate->appliesToDateRange($range)) {
                if ( ! $bestRate || $rate->getUnitPrice() < $bestRate->getUnitPrice()) {
                    $bestRate = $rate;
                }
            }
        }

        if ($bestRate) {
            return $bestRate;
        }
        return $equipment->getBaseRate();
    }
}
