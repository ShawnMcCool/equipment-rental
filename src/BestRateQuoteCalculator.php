<?php namespace Rental;

class BestRateQuoteCalculator implements RateQuoteCalculator
{
    // could be further extracted / refactored
    public function getQuotesFor(RentalQuery $query)
    {
        $rateQuote = new RateQuote($query->getEquipment());
        $dayCount = $query->getTotalDayCount();

        while ($dayCount > 0) {
            $rate = $this->getBestRateForDays($query->getApplicableRates(), $dayCount);
            $rateQuote->add(RateQuoteLineItem::make($rate, 1));
            $dayCount -= $rate->getUnitDays();
        }

        return $rateQuote;
    }

    private function getBestRateForDays($rates, $dayCount)
    {
        $bestRate = null;

        /** @var Rate $rate */
        foreach ($rates as $rate)
            if ( ! $bestRate || $rate->getPriceForDays($dayCount) < $rate->getPriceForDays($dayCount))
                $bestRate = $rate;

        return $bestRate;
    }
}
