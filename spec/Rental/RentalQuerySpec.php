<?php

namespace spec\Rental;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rental\Currency;
use Rental\Equipment;
use Rental\Price;
use Rental\Rate;
use Rental\RentalPeriod;

class RentalQuerySpec extends ObjectBehavior
{
    function let()
    {
        $price = Price::fromString('12', Currency::fromString('EUR'));
        $equipment = new Equipment('Hammer', new Rate(null, $price, 1));
        $rentalPeriod = RentalPeriod::fromDateTime(new \DateTime('2014-07-01'), new \DateTime('2014-07-07'));

        $this->beConstructedWith($equipment, $rentalPeriod);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Rental\RentalQuery');
    }

    function it_contains_a_rental_period()
    {
        $this->getRentalPeriod()->shouldHaveType('Rental\RentalPeriod');
    }

    function it_contains_equipment()
    {
        $this->getEquipment()->shouldHaveType('Rental\Equipment');
    }
}
