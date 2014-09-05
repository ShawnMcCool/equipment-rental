<?php

namespace spec\Rental;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rental\Currency;
use Rental\Equipment;
use Rental\Price;
use Rental\Rate;
use Rental\RentalPeriod;
use Rental\RentalQuery;

class BestRateQuoteCalculatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Rental\BestRateQuoteCalculator');
    }

    function it_finds_a_base_daily_rate_price_in_the_absence_of_other_rates()
    {
//        $this->getQuotesFor($this->getRentalQuery());
    }

    private function getRentalQuery()
    {
        $equipment = new Equipment('Jack Hammer', new Rate(null, Price::fromString('10', Currency::fromString('EUR'), 1)));
        $rentalPeriod = RentalPeriod::fromDateTime(new \DateTime('2014-07-01'), new \DateTime('2014-07-07'));
        new RentalQuery($equipment, $rentalPeriod);
    }
}
