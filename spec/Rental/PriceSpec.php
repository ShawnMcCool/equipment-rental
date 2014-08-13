<?php

namespace spec\Rental;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rental\Currency;
use Rental\Price;

class PriceSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('fromString', [127.38, Currency::fromString('EUR')]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Rental\Price');
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

    function it_can_add_prices()
    {
        $addPrice = Price::fromString('30', Currency::fromString('EUR'));
        $newPrice = $this->add($addPrice);
        $newPrice->shouldHaveType('Rental\Price');
        $newPrice->getValue()->shouldBe(157.38);
    }

    function it_throws_on_incompatible_currency()
    {
        $incompatiblePrice = Price::fromString('30', Currency::fromString('USD'));
        $this->shouldThrow('\InvalidArgumentException')->during('add', [$incompatiblePrice]);
    }

    function it_can_multiply_prices()
    {
        $price = $this->times(3);
        $price->shouldHaveType('Rental\Price');
        $price->getValue()->shouldBe(382.14);
    }
}
