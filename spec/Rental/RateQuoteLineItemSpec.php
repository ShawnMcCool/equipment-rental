<?php

namespace spec\Rental;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rental\Currency;
use Rental\Price;
use Rental\Rate;

class RateQuoteLineItemSpec extends ObjectBehavior
{
    function let()
    {
        $rate = $this->buildRate();
        $this->beConstructedThrough('make', [$rate, 2]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Rental\RateQuoteLineItem');
    }

    function it_stores_a_rate_and_its_quantity()
    {
        $this->getRate()->shouldHaveType('Rental\Rate');
        $this->getRate()->getPrice()->getValue()->shouldBe('12');
        $this->getQuantity()->shouldReturn(2);
    }

    function it_adjusts_the_quantity()
    {
        $this->modifyQuantity(1);
        $this->getQuantity()->shouldBe(3);
        $this->modifyQuantity(-2);
        $this->getQuantity()->shouldBe(1);
    }

    function it_calculates_its_line_total()
    {
        $price = $this->getLineTotal();
        $price->shouldHaveType('Rental\Price');
        $price->getValue()->shouldBe(24);

        $this->modifyQuantity(1);
        $price = $this->getLineTotal();
        $price->getValue()->shouldBe(36);
    }

    /**
     * @return static
     */
    private function buildPrice()
    {
        $price = Price::fromString('12', Currency::fromString('EUR'));
        return $price;
    }

    /**
     * @return Rate
     */
    private function buildRate()
    {
        $price = $this->buildPrice();
        $rate = new Rate(null, $price, 1);
        return $rate;
    }
}
