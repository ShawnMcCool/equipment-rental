<?php namespace Rental;

class RateQuoteProvider
{
    private $calculators = [];

    public function addCalculator(RateQuoteCalculator $calculator)
    {
        $this->calculators[] = $calculator;
    }

    public function getCalculators()
    {
        return $this->calculators;
    }

    public function getQuotesFor(RentalQuery $query)
    {
        $quotes = [];
        /** @var RateQuoteCalculator $calculator */
        foreach ($this->calculators as $calculator) {
            $quotes = array_merge($quotes, $calculator->getQuotesFor($query));
        }
        return $quotes;
    }
}
