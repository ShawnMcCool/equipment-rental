<?php namespace Rental;

class SingleRateRateQuoteCalculator implements RateQuoteCalculator
{
    public function getQuotesFor(RentalQuery $query)
    {
        $quotes = [];

        foreach ($query->getApplicableRates() as $rate)
            $quotes[] = $this->buildQuote($query->getEquipment(), $rate, $query->getRentalPeriod());

        return $quotes;
    }

    private function buildQuote(Equipment $equipment, Rate $rate, RentalPeriod $requestedPeriod)
    {
        /** @var RentalPeriod $requestedPeriod */
        /** @var Rate $rate */
        $quantity = ceil($requestedPeriod->getDayCount() / $rate->getUnitDays());

        $quote = new RateQuote($equipment);
        $quote->add(RateQuoteLineItem::make($rate, $quantity));

        return $quote;
    }
}
