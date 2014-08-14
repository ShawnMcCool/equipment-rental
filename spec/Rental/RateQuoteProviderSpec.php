<?php

namespace spec\Rental;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rental\Currency;
use Rental\Equipment;
use Rental\Price;
use Rental\Rate;
use Rental\RateQuoteCalculator;
use Rental\RentalPeriod;
use Rental\RentalQuery;
use Rental\SingleRateRateQuoteCalculator;

class RateQuoteProviderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Rental\RateQuoteProvider');
    }

    function it_contains_rate_quote_calculators(RateQuoteCalculator $calculator)
    {
        $this->addCalculator($calculator);
        $calculators = $this->getCalculators();
        $calculators[0]->shouldHaveType('Rental\RateQuoteCalculator');
        $calculators[0]->shouldBe($calculator);
    }

    function it_returns_rate_quotes_created_by_the_calculators()
    {
        $price = Price::fromString('1', Currency::fromString('EUR'));
        $baseRate = new Rate(null, $price, 1);
        $equipment = new Equipment('Truck', $baseRate);

        // 38 days
        $queryPeriod = RentalPeriod::fromDateTime(new \DateTime('2014-08-01'), new \DateTime('2014-09-07'));
        $query = new RentalQuery($equipment, $queryPeriod);

        $this->addCalculator(new SingleRateRateQuoteCalculator);

        $quotes = $this->getQuotesFor($query);
        $quote = $quotes[0];
        $quote->shouldHaveType('Rental\RateQuote');
        // 38 days * 1 eur
        $price = Price::fromString('38', Currency::fromString('EUR'));
        $quote->getSubTotal()->equals($price)->shouldBe(true);
    }
}
