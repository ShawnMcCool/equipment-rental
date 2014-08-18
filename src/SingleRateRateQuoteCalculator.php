<?php namespace Rental;

class SingleRateRateQuoteCalculator implements RateQuoteCalculator
{
    public function getQuotesFor(RentalQuery $query)
    {
        $quotes = [];

        $equipment = $query->getEquipment();
        $rentalPeriod = $query->getRentalPeriod();

        /** @var Rate $rate */
        foreach ($equipment->getRates() as $rate) {
            if ($rate->overlapsWithPeriod($rentalPeriod)) {
                $quotes[] = $this->buildQuote($equipment, $rate, $rentalPeriod);
            }
        }

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
