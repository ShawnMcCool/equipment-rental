<?php

namespace spec\Thing;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Thing\Currency;
use Thing\DateRange;
use Thing\Price;
use Thing\Rate;

class EquipmentSpec extends ObjectBehavior
{
    function let()
    {
        $baseRate = new Rate(null, Price::fromString(100, Currency::fromString('EUR')), 1);
        $this->beConstructedWith('Wrench', $baseRate);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Thing\Equipment');
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('Wrench');
    }

    function it_has_a_base_rate()
    {
        $this->getBaseRate()->shouldHaveType('Thing\Rate');
        $this->getBaseRate()->getPrice()->getValue()->shouldBe(100);
    }

    function it_can_have_many_rates()
    {
        $price = Price::fromString('12.50', Currency::fromString('EUR'));
        $this->addRate(null, $price, 1);
        $this->getRates()->shouldHaveCount(1);

        $dateRange = DateRange::fromDateTime(new \DateTime('2014-07-01'), new \DateTime('2014-07-07'));
        $this->addRate($dateRange, $price, 1);
        $this->getRates()->shouldHaveCount(2);
    }
}
