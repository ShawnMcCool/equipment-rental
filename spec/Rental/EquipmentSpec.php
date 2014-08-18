<?php

namespace spec\Rental;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rental\Currency;
use Rental\RentalPeriod;
use Rental\Price;
use Rental\Rate;

class EquipmentSpec extends ObjectBehavior
{
    function let()
    {
        $baseRate = new Rate(null, Price::fromString(100, Currency::fromString('EUR')), 1);
        $this->beConstructedWith('Wrench', $baseRate);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Rental\Equipment');
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('Wrench');
    }

    function it_has_a_base_rate()
    {
        $this->getBaseRate()->shouldHaveType('Rental\Rate');
        $this->getBaseRate()->getPrice()->getValue()->shouldBe(100);
    }

    function it_can_have_many_rates()
    {
        $price = Price::fromString('12.50', Currency::fromString('EUR'));
        $this->addRate(null, $price, 1);
        $this->getRates()->shouldHaveCount(2);

        $dateRange = RentalPeriod::fromDateTime(new \DateTime('2014-07-01'), new \DateTime('2014-07-07'));
        $this->addRate($dateRange, $price, 1);
        $this->getRates()->shouldHaveCount(3);
    }
}
