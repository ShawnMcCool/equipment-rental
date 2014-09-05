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
    /**
     * @var Equipment
     */
    private $equipment;

    function let()
    {
        $price = Price::fromString('12', Currency::fromString('EUR'));
        $this->equipment = new Equipment('Hammer', new Rate(null, $price, 1));
        $rentalPeriod = RentalPeriod::fromDateTime(new \DateTime('2014-07-01'), new \DateTime('2014-07-07'));

        $this->beConstructedWith($this->equipment, $rentalPeriod);
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

    function it_has_rates()
    {
        $this->getRates()->shouldHaveCount(1);

        $this->equipment->addRate(null, Price::fromString('11', Currency::fromString('EUR')), 1);
        $this->getRates()->shouldHaveCount(2);
    }

    function it_has_rates_that_overlap_with_rental_period()
    {
        $this->getApplicableRates()->shouldHaveCount(1);

        $this->equipment->addRate(null, Price::fromString('11', Currency::fromString('EUR')), 1);
        $this->getApplicableRates()->shouldHaveCount(2);

        $this->equipment->addRate(RentalPeriod::fromDateTime(new \DateTime('2014-07-05'), new \DateTime('2014-07-10')), Price::fromString('11', Currency::fromString('EUR')), 1);
        $this->getApplicableRates()->shouldHaveCount(3);

        $this->equipment->addRate(RentalPeriod::fromDateTime(new \DateTime('2014-07-08'), new \DateTime('2014-07-10')), Price::fromString('11', Currency::fromString('EUR')), 1);
        $this->getApplicableRates()->shouldHaveCount(3);

        $this->equipment->addRate(RentalPeriod::fromDateTime(new \DateTime('2014-06-08'), new \DateTime('2014-06-30')), Price::fromString('11', Currency::fromString('EUR')), 1);
        $this->getApplicableRates()->shouldHaveCount(3);
    }

    function it_has_a_count_of_total_days_in_period()
    {
        $this->getTotalDayCount();
    }
}
