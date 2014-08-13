<?php

namespace spec\Rental;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rental\Currency;

class CurrencySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('fromString', ['eur']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Rental\Currency');
    }

    function it_stores_a_currency()
    {
        $this->getCurrency()->shouldBe('EUR');
    }

    function it_compares_currencies_for_equality()
    {
        $sameCurrency = Currency::fromString('EUR');

        $this->equals($sameCurrency)->shouldBe(true);
    }
}
