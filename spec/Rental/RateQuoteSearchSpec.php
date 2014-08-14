<?php

namespace spec\Rental;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rental\Currency;
use Rental\Equipment;
use Rental\Price;
use Rental\Rate;
use Rental\RateQuoteProvider;
use Rental\RentalPeriod;
use Rental\RentalQuery;
use Rental\SingleRateRateQuoteCalculator;

class RateQuoteSearchSpec extends ObjectBehavior
{
    function let()
    {
        $provider = new RateQuoteProvider;
        $provider->addCalculator(new SingleRateRateQuoteCalculator);

        $this->beConstructedWith($provider);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Rental\RateQuoteSearch');
    }

    function it_returns_the_cheapest_possible_rate()
    {
        $query = $this->getQuery();
        $quote = $this->getCheapestQuote($query);
        $quote->shouldHaveType('Rental\RateQuote');
        $quote->getSubTotal()->equals(Price::fromString('38', Currency::fromString('EUR')))->shouldBe(true);
    }

    /**
     * @return RentalQuery
     */
    private function getQuery()
    {
        $price = Price::fromString('1', Currency::fromString('EUR'));
        $baseRate = new Rate(null, $price, 1);
        $equipment = new Equipment('Truck', $baseRate);

        // 38 days
        $queryPeriod = RentalPeriod::fromDateTime(new \DateTime('2014-08-01'), new \DateTime('2014-09-07'));
        $query = new RentalQuery($equipment, $queryPeriod);
        return $query;
    }
}
