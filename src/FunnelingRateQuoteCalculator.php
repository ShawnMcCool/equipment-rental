<?php namespace Rental;

class FunnelingRateQuoteCalculator implements RateQuoteCalculator
{
    /**
     * @param RentalQuery $query
     * @return array
     */
    public function getQuotesFor(RentalQuery $query)
    {
        $rates = $this->getApplicableRates($query);
        $equipment = $query->getEquipment();
        $days = $query->getRentalPeriod()->getDayCount();

        $quote = new RateQuote($equipment);

        while ($days > 0) {
            $bestRate = $this->getBestRate($rates, $days);
            var_dump($bestRate);
            $days -= $bestRate->getUnitDays();
            $quote->add(RateQuoteLineItem::make($bestRate, 1));
        }

        return [$quote];
    }

    /**
     * @return Rate $rate
     */
    private function getBestRate($rates, $days)
    {
        $bestRate = null;
        /** @var Rate $rate */
        foreach ($rates as $rate) {
            if (is_null($bestRate) || $rate->getPriceForDays($days)->isLessThan($bestRate->getPriceForDays($days))) {
                $bestRate = $rate;
            }
        }
        return $bestRate;
    }

    private function getApplicableRates(RentalQuery $query)
    {
        $rates = [];
        foreach ($query->getEquipment()->getRates() as $rate) {
            if ($rate->overlapsWithPeriod($query->getRentalPeriod())) {
                $rates[] = $rate;
            }
        }
        return $rates;
    }

}
