<?php

namespace spec\Rental;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rental\Currency;
use Rental\Equipment;
use Rental\Price;
use Rental\Rate;
use Rental\RateQuoteLineItem;

class RateQuoteSpec extends ObjectBehavior
{
    function let()
    {
        $baseRate = new Rate(null, Price::fromString('12', Currency::fromString('EUR')), 1);
        $equipment = new Equipment('Wrench', $baseRate);

        $this->beConstructedWith($equipment);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Rental\RateQuote');
    }

    function it_references_equipment()
    {
        $this->getEquipment()->shouldHaveType('Rental\Equipment');
    }

    function it_references_line_items()
    {
        $rate = new Rate(null, Price::fromString('12.12', Currency::fromString('EUR')), 1);

        $this->add(RateQuoteLineItem::make($rate, 3));
        $this->getLineItems()->shouldHaveCount(1);
    }

    function it_stacks_instances_of_the_same_rate()
    {
        $rate = new Rate(null, Price::fromString('12.12', Currency::fromString('EUR')), 1);

        $this->add(RateQuoteLineItem::make($rate, 3));
        $this->add(RateQuoteLineItem::make($rate, 3));
        $this->getLineItems()->shouldHaveCount(1);
    }

    function it_calculates_a_subtotal_of_line_items()
    {
        $rate = new Rate(null, Price::fromString('12.12', Currency::fromString('EUR')), 1);
        $this->add(RateQuoteLineItem::make($rate, 3));

        /** @var Price $subtotal */
        $subtotal = $this->getSubTotal();
        $subtotal->shouldHaveType('Rental\Price');
        $subtotal->getValue()->shouldBe(36.36);
    }
}
