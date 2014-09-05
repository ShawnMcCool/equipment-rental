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
        // eg search for a period where the 2 * weekly rate is cheaper than 12 * daily rate or (1 * week) + (6 * daily rate)
    }

    function it_finds_the_lowest_base_monthly_rate_in_the_absence_of_other_rates()
    {
        // eg search for a period where the monthly rate is cheaper than (3 * weekly rates) + (5 * daily rate)
        // eg search for a period where the (1 * monthly) + (1 * weekly) rate is cheaper than (5 * weekly rate)
    }

    function it_finds_a_daily_rate_price_from_date_range_rate()
    {
        // Date Range daily rate supplied
    }

    function it_finds_a_weekly_rate_price_from_date_range_rate()
    {
        // Date Range weekly rate
        // Same as: it_finds_the_lowest_base_weekly_rate_in_the_absence_of_other_rates (but with dates)
    }

    function it_finds_a_monthly_rate_price_from_date_range_rate()
    {
        // Date Range weekly rate
        // Same as: it_finds_the_lowest_base_monthly_rate_in_the_absence_of_other_rates (but with dates)
    }
}
