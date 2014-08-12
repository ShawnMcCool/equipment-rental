<?php

namespace spec\Thing;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Thing\Currency;
use Thing\DateRange;
use Thing\Price;

class RateSpec extends ObjectBehavior
{
    function let()
    {
        $dateRange = DateRange::fromDateTime(new \DateTime('2014-07-01'), new \DateTime('2014-07-07'));
        $price = Price::fromString(70, Currency::fromString('EUR'));
        $this->beConstructedWith($dateRange, $price, 1);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Thing\Rate');
    }

    function it_tests_whether_or_not_it_applies_to_a_date_range()
    {
        $endsInsideOfRange = DateRange::fromDateTime(new \DateTime('2014-06-01'), new \DateTime('2014-07-02'));
        $this->appliesToDateRange($endsInsideOfRange)->shouldBe(true);

        $startsInsideOfRange = DateRange::fromDateTime(new \DateTime('2014-07-02'), new \DateTime('2014-08-02'));
        $this->appliesToDateRange($startsInsideOfRange)->shouldBe(true);

        $encapsulatesRange = DateRange::fromDateTime(new \DateTime('2014-06-02'), new \DateTime('2014-08-02'));
        $this->appliesToDateRange($encapsulatesRange)->shouldBe(true);

        $endsBeforeRange = DateRange::fromDateTime(new \DateTime('2014-06-02'), new \DateTime('2014-06-30'));
        $this->appliesToDateRange($endsBeforeRange)->shouldBe(false);

        $startsAfterRange = DateRange::fromDateTime(new \DateTime('2014-07-08'), new \DateTime('2014-08-02'));
        $this->appliesToDateRange($startsAfterRange)->shouldBe(false);
    }

    function it_returns_the_price()
    {
        $this->getPrice()->shouldHaveType('Thing\Price');
        $this->getPrice()->getValue()->shouldBe(70);
    }

    function it_returns_unit_price()
    {
        $this->getUnitPrice()->getValue()->shouldBe(70);
    }
}
