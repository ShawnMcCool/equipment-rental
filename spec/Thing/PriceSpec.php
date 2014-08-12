<?php

namespace spec\Thing;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Thing\Currency;
use Thing\Price;

class PriceSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('fromString', [127.38, Currency::fromString('EUR')]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Thing\Price');
    }

    function it_has_a_value()
    {
        $this->getValue()->shouldBe(127.38);
    }

    function it_has_a_currency()
    {
        $euro = Currency::fromString('EUR');
        $this->getCurrency()->equals($euro)->shouldReturn(true);
    }

    function it_can_compare_equality_with_other_prices()
    {
        $samePrice = Price::fromString(127.38, Currency::fromString('EUR'));
        $this->equals($samePrice)->shouldReturn(true);
    }
}
