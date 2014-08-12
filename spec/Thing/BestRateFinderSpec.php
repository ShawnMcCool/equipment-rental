<?php

namespace spec\Thing;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Thing\Currency;
use Thing\DateRange;
use Thing\Equipment;
use Thing\Price;
use Thing\Rate;

class BestRateFinderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Thing\BestRateFinder');
    }
//
//    function it_finds_a_base_price_in_the_absence_of_other_rates()
//    {
//        $equipment = $this->getEquipment(127);
//        $range = $this->getRange('2014-07-01', '2014-07-07');
//
//        $this->findForRange($equipment, $range)->shouldHaveType('Thing\Rate');
//        $rate = $this->findForRange($equipment, $range);
//        $rate->getUnitPrice()->getValue()->shouldBe(127);
//    }
//
//    function it_finds_a_discounted_rate()
//    {
//        $equipment = $this->getEquipment(127);
//        $equipment->addRate(null, $this->getPrice(10), 1);
//
//        $rate = $this->findForRange($equipment, $this->getRange('2014-07-01', '2014-07-07'));
//        $rate->getUnitPrice()->getValue()->shouldBe(10);
//    }
//
//    function it_finds_the_lowest_discounted_rate()
//    {
//        $equipment = $this->getEquipment(127);
//        $equipment->addRate(null, $this->getPrice(70), 1);
//        $equipment->addRate(null, $this->getPrice(70), 7);
//
//        $rate = $this->findForRange($equipment, $this->getRange('2014-07-01', '2014-07-07'));
//        $rate->getUnitPrice()->getValue()->shouldBe(10);
//    }
//
//    function it_finds_the_lowest_two_week_rate()
//    {
//        $equipment = $this->getEquipment(127);
//        $equipment->addRate(null, $this->getPrice(70), 1);
//        $equipment->addRate(null, $this->getPrice(70), 7);
//
//        $rate = $this->findForRange($equipment, $this->getRange('2014-07-01', '2014-07-14'));
//        $rate->getUnitPrice()->getValue()->shouldBe(10);
//    }
//
//    private function getRate($price, $days = 1)
//    {
//        return new Rate(null, $this->getPrice($price), $days);
//    }
//
//    /**
//     * @return Equipment
//     */
//    private function getEquipment($price)
//    {
//        $equipment = new Equipment('Wrench', $this->getRate($price));
//        return $equipment;
//    }
//
//    /**
//     * @return static
//     */
//    private function getRange($start, $end)
//    {
//        $range = DateRange::fromDateTime(new \DateTime($start), new \DateTime($end));
//        return $range;
//    }
//
//    private function getPrice($price)
//    {
//        return Price::fromString($price, Currency::fromString('EUR'));
//    }
}
