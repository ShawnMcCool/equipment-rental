<?php

namespace spec\Thing;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Thing\Currency;
use Thing\DateRange;
use Thing\Equipment;
use Thing\Price;
use Thing\Rate;

class BestRateFinderSpec extends ObjectBehavior
{
    function let()
    {
        $baseRate = new Rate(null, Price::fromString('127', Currency::fromString('EUR')), 1);
        $equipment = new Equipment('Wrench', $baseRate);

        $this->beConstructedWith($equipment);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Thing\BestRateFinder');
    }

    function it_finds_a_base_price_in_the_absence_of_other_rates()
    {
        $range = DateRange::fromDateTime(new \DateTime('2014-07-01'), new \DateTime('2014-07-07'));
        $this->findForRange($range)->shouldHaveType('Thing\Rate');
        $this->findForRange($range)->getUnitPrice()->getValue()->shouldBe(127);
    }
}
