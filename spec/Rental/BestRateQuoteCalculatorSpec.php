<?php

namespace spec\Rental;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rental\Currency;
use Rental\Equipment;
use Rental\Price;
use Rental\Rate;
use Rental\RateQuote;
use Rental\RateQuoteLineItem;
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
        $baseRate = new Rate(null, Price::fromString('10', Currency::fromString('EUR')), 1);
        $equipment = new Equipment('Jack Hammer', $baseRate);
        $rentalPeriod = RentalPeriod::fromDateTime(new \DateTime('2014-07-01'), new \DateTime('2014-07-07'), 1);
        $rentalQuery = new RentalQuery($equipment, $rentalPeriod);

        $quotes = $this->getQuotesFor($rentalQuery);
        $quote = $quotes[0];

        /** @var RateQuote $quote */
        $quote->getLineItems()->shouldHaveCount(1);
        $lineItems = $quote->getLineItems();
        /** @var RateQuoteLineItem $lineItem */
        $lineItem = $lineItems[0];
        $lineItem->getRate()->shouldBe($baseRate);
    }

    function it_finds_the_lowest_base_weekly_rate_in_the_absence_of_other_rates()
    {
        // eg search for a period where the 1 * weekly rate is cheaper than 6 * daily rate
        $baseRate = new Rate(null, Price::fromString('10', Currency::fromString('EUR')), 1);
        $equipment = new Equipment('Jack Hammer', $baseRate);
        $rentalPeriod = RentalPeriod::fromDateTime(new \DateTime('2014-07-01'), new \DateTime('2014-07-07'), 1);
        $rentalQuery = new RentalQuery($equipment, $rentalPeriod);

        $weekPrice = Price::fromString('65', Currency::fromString('EUR'));
        $equipment->addRate(null, $weekPrice, 7);

        $quotes = $this->getQuotesFor($rentalQuery);
        $quote = $quotes[0];

        /** @var RateQuote $quote */
        $quote->getLineItems()->shouldHaveCount(1);
        $lineItems = $quote->getLineItems();
        /** @var RateQuoteLineItem $lineItem */
        $lineItem = $lineItems[0];
        $lineItem->getRate()->getPrice()->equals($weekPrice);
    }

    function it_finds_the_lowest_base_monthly_rate_in_the_absence_of_other_rates()
    {
        // eg search for a period where the monthly rate is cheaper than (3 * weekly rates) + (5 * daily rate)
        // daily rate - 10
        // daily rate - 10
        $baseRate = new Rate(null, Price::fromString('10', Currency::fromString('EUR')), 1);
        $equipment = new Equipment('Jack Hammer', $baseRate);
        $rentalPeriod = RentalPeriod::fromDateTime(new \DateTime('2014-07-01'), new \DateTime('2014-07-07'), 1);
        $rentalQuery = new RentalQuery($equipment, $rentalPeriod);

        // weekly rate - 60
        $weekPrice = Price::fromString('65', Currency::fromString('EUR'));
        $equipment->addRate(null, $weekPrice, 7);

        // 3 weekly + 5 daily = 250
        // monthly rate = 240
        $monthPrice = Price::fromString('240', Currency::fromString('EUR'));
        $equipment->addRate(null, $monthPrice, 30);

        $quotes = $this->getQuotesFor($rentalQuery);
        $quote = $quotes[0];

        /** @var RateQuote $quote */
        $quote->getLineItems()->shouldHaveCount(1);
        $lineItems = $quote->getLineItems();
        /** @var RateQuoteLineItem $lineItem */
        $lineItem = $lineItems[0];
        $lineItem->getRate()->getPrice()->equals($monthPrice);
    }

    function it_finds_a_daily_rate_price_from_date_range_rate()
    {
        // Date Range daily rate supplied
        $dailyPrice = Price::fromString('10', Currency::fromString('EUR'));
        $equipment = new Equipment('Jack Hammer', new Rate(null, $dailyPrice, 1));

        $rentalQuery = new RentalQuery(
            $equipment,
            RentalPeriod::fromDateTime(new \DateTime('2014-07-01'), new \DateTime('2014-07-07'), 1)
        );

        $quotes = $this->getQuotesFor($rentalQuery);
        $quote = $quotes[0];

        /** @var RateQuote $quote */
        $quote->getLineItems()->shouldHaveCount(1);
        $lineItems = $quote->getLineItems();
        /** @var RateQuoteLineItem $lineItem */
        $lineItem = $lineItems[0];
        $lineItem->getRate()->getPrice()->equals($dailyPrice);

        //////////
        $tempPrice = Price::fromString('8', Currency::fromString('EUR'));
        $equipment->addRate(
            RentalPeriod::fromDateTime(new \DateTime('2014-07-04'), new \DateTime('2014-07-10')),
            $tempPrice,
            1
        );

        $quotes = $this->getQuotesFor($rentalQuery);
        $quote = $quotes[0];

        /** @var RateQuote $quote */
        $quote->getLineItems()->shouldHaveCount(1);
        $lineItems = $quote->getLineItems();
        /** @var RateQuoteLineItem $lineItem */
        $lineItem = $lineItems[0];
        $lineItem->getRate()->getPrice()->equals($tempPrice);

    }
}
