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

class FunnelingRateQuoteCalculatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Rental\FunnelingRateQuoteCalculator');
    }

//    function it_finds_the_best_rate_one()
//    {
//        $equipment = $this->buildEquipment();
//
//        // 7 total for one week
//        $rentalPeriod = RentalPeriod::fromDateTime(new \DateTime('2014-06-01'), new \DateTime('2014-06-07'));
//        $equipment->addRate($rentalPeriod, Price::fromString('7', Currency::fromString('EUR')), 7);
//
//        $queryPeriod = RentalPeriod::fromDateTime(new \DateTime('2014-06-01'), new \DateTime('2014-06-07'));
//        $query = new RentalQuery($equipment, $queryPeriod);
//
//        $quotes = $this->getQuotesFor($query);
//        $quote = $quotes[0];
//
//        $quote->getSubTotal()->getValue()->shouldBe(7);
//    }

    function it_finds_the_best_rate_two()
    {
        $equipment = $this->buildEquipment();

        // 7 total for one week
        $rentalPeriod = RentalPeriod::fromDateTime(new \DateTime('2014-06-01'), new \DateTime('2014-06-07'));
        $equipment->addRate($rentalPeriod, Price::fromString('10', Currency::fromString('EUR')), 7);

        $queryPeriod = RentalPeriod::fromDateTime(new \DateTime('2014-06-01'), new \DateTime('2014-06-10'));
        $query = new RentalQuery($equipment, $queryPeriod);

        $quotes = $this->getQuotesFor($query);

        /** @var RateQuote $quote */
        $quote = $quotes[0];
        $quote->getLineItems()->shouldHaveCount(2);

        $quote->getSubTotal()->getValue()->shouldBe(13);
    }
//
//    function it_finds_the_best_rate_three()
//    {
//        $equipment = $this->buildEquipment();
//
//        // 7 total for one week
//        $equipment->addRate(null, Price::fromString('7', Currency::fromString('EUR')), 7);
//
//        // 6 total for 8 days
//        $equipment->addRate(null, Price::fromString('6', Currency::fromString('EUR')), 8);
//
//        // query
//        $queryPeriod = RentalPeriod::fromDateTime(new \DateTime('2014-06-01'), new \DateTime('2014-06-7'));
//        $query = new RentalQuery($equipment, $queryPeriod);
//
//        $quotes = $this->getQuotesFor($query);
//        $quote = $quotes[0];
//
//        $quote->getSubTotal()->getValue()->shouldBe(6);
//    }
//
//
//    function it_finds_the_best_rate_four()
//    {
//        $equipment = $this->buildEquipment();
//
//        // 7 total for one week
//        $equipment->addRate(null, Price::fromString('7', Currency::fromString('EUR')), 7);
//
//        // 6 total for 8 days
//        $equipment->addRate(null, Price::fromString('6', Currency::fromString('EUR')), 8);
//
//        // query
//        $queryPeriod = RentalPeriod::fromDateTime(new \DateTime('2014-06-01'), new \DateTime('2014-06-10'));
//        $query = new RentalQuery($equipment, $queryPeriod);
//
//        $quotes = $this->getQuotesFor($query);
//        $quote = $quotes[0];
//
//        $quote->getSubTotal()->getValue()->shouldBe(6);
//    }

    // ------------------------
    private function buildEquipment()
    {
        // THE BASE PRICE IS 1 PER DAY
        $price = Price::fromString('1', Currency::fromString('EUR'));
        $baseRate = new Rate(null, $price, 1);
        $equipment = new Equipment('Truck', $baseRate);

        return $equipment;
    }
}
