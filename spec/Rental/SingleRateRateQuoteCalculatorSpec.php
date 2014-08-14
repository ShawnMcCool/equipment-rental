<?php

namespace spec\Rental;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rental\Currency;
use Rental\Equipment;
use Rental\Price;
use Rental\Rate;
use Rental\RateQuote;
use Rental\RentalPeriod;
use Rental\RentalQuery;

class SingleRateRateQuoteCalculatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Rental\SingleRateRateQuoteCalculator');
    }

    function it_creates_valid_rate_quotes_for_single_unit_rates()
    {
        $equipment = $this->buildEquipment();
        $queryPeriod = RentalPeriod::fromDateTime(new \DateTime('2014-08-01'), new \DateTime('2014-09-07'));
        $query = new RentalQuery($equipment, $queryPeriod);

        $quotes = $this->getQuotesFor($query);
        $quote = $quotes[0];

        /** @var RateQuote $quote */
        $quote->shouldHaveType('Rental\RateQuote');
        // equipment should be assigned
        $quote->getEquipment()->shouldBe($equipment);
        // only the base rate is valid for the requested range
        $quote->getLineItems()->shouldHaveCount(1);
        // price should be base rate times number of days 38 * 12
        $quote->getSubTotal()->shouldHaveType('Rental\Price');
        $correctPrice = Price::fromString('456', Currency::fromString('EUR'));
        $quote->getSubTotal()->equals($correctPrice)->shouldBe(true);
    }

    function it_creates_valid_rate_quotes_for_multi_unit_rates()
    {
        $price = Price::fromString('12', Currency::fromString('EUR'));
        $baseRate = new Rate(null, $price, 10);
        $equipment = new Equipment('Truck', $baseRate);

        $queryPeriod = RentalPeriod::fromDateTime(new \DateTime('2014-08-01'), new \DateTime('2014-09-07'));
        $query = new RentalQuery($equipment, $queryPeriod);

        $quotes = $this->getQuotesFor($query);
        $quote = $quotes[0];

        /** @var RateQuote $quote */
        $quote->shouldHaveType('Rental\RateQuote');
        // equipment should be assigned
        $quote->getEquipment()->shouldBe($equipment);
        // only the base rate is valid for the requested range
        $quote->getLineItems()->shouldHaveCount(1);
        // price should be base rate times number of days 38 * 12
        $quote->getSubTotal()->shouldHaveType('Rental\Price');
        $correctPrice = Price::fromString('48', Currency::fromString('EUR'));
        $quote->getSubTotal()->equals($correctPrice)->shouldBe(true);
    }

    function it_returns_one_rate_quote_per_applicable_rate()
    {
        $equipment = $this->buildEquipment();

        //
        $queryPeriod = RentalPeriod::fromDateTime(new \DateTime('2014-07-01'), new \DateTime('2014-07-07'));
        $query = new RentalQuery($equipment, $queryPeriod);

        $this->getQuotesFor($query)->shouldHaveCount(2);

        //
        $queryPeriod = RentalPeriod::fromDateTime(new \DateTime('2014-06-01'), new \DateTime('2014-07-07'));
        $query = new RentalQuery($equipment, $queryPeriod);

        $this->getQuotesFor($query)->shouldHaveCount(3);
    }

    private function buildEquipment()
    {
        $price = Price::fromString('12', Currency::fromString('EUR'));
        $baseRate = new Rate(null, $price, 1);
        $equipment = new Equipment('Truck', $baseRate);

        // first rate
        $rentalPeriod = RentalPeriod::fromDateTime(new \DateTime('2014-06-01'), new \DateTime('2014-06-07'));
        $equipment->addRate($rentalPeriod, Price::fromString('10', Currency::fromString('EUR')), 1);

        // second rate
        $rentalPeriod = RentalPeriod::fromDateTime(new \DateTime('2014-07-01'), new \DateTime('2014-07-07'));
        $equipment->addRate($rentalPeriod, Price::fromString('10', Currency::fromString('EUR')), 2);

        return $equipment;
    }
}
