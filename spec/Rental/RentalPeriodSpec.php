<?php

namespace spec\Rental;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rental\RentalPeriod;

class RentalPeriodSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('fromDateTime', [new \DateTime('2014-07-01'), new \DateTime('2014-07-07')]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Rental\RentalPeriod');
    }

    function it_returns_the_start_date()
    {
        $this->getStartDate()->format('Y-m-d')->shouldBe('2014-07-01');
    }

    function it_returns_the_end_date()
    {
        $this->getEndDate()->format('Y-m-d')->shouldBe('2014-07-07');
    }

    function it_tests_for_equality_between_date_ranges()
    {
        $sameDateRange = RentalPeriod::fromDateTime(new \DateTime('2014-07-01'), new \DateTime('2014-07-07'));
        $this->equals($sameDateRange)->shouldBe(true);
    }

    function it_tests_for_equality_between_different_timezones()
    {
        $diffDateRange = RentalPeriod::fromDateTime(new \DateTime('2014-07-01', new \DateTimeZone('Europe/London')), new \DateTime('2014-07-07'));
        $this->equals($diffDateRange)->shouldBe(false);
    }

    function it_identifies_if_a_date_falls_within_its_range()
    {
        $withinRange = new \DateTime('2014-07-01');
        $this->isWithinRange($withinRange)->shouldBe(true);
    }

    function it_identifies_if_a_date_does_not_fall_within_its_range()
    {
        $outOfRange = new \DateTime('2014-06-30');
        $this->isWithinRange($outOfRange)->shouldBe(false);
    }

    function it_checks_if_it_overlaps_with_a_range()
    {
        $internal = RentalPeriod::fromDateTime(new \DateTime('2014-07-03'), new \DateTime('2014-07-05'));
        $this->overlapsWithRange($internal)->shouldBe(true);

        $before = RentalPeriod::fromDateTime(new \DateTime('2014-06-03'), new \DateTime('2014-06-30'));
        $this->overlapsWithRange($before)->shouldBe(false);

        $after = RentalPeriod::fromDateTime(new \DateTime('2014-07-10'), new \DateTime('2014-07-30'));
        $this->overlapsWithRange($after)->shouldBe(false);

        $startDuring = RentalPeriod::fromDateTime(new \DateTime('2014-07-04'), new \DateTime('2014-07-30'));
        $this->overlapsWithRange($startDuring)->shouldBe(true);

        $endDuring = RentalPeriod::fromDateTime(new \DateTime('2014-06-10'), new \DateTime('2014-07-03'));
        $this->overlapsWithRange($endDuring)->shouldBe(true);

        $encapsulates = RentalPeriod::fromDateTime(new \DateTime('2014-06-10'), new \DateTime('2014-08-03'));
        $this->overlapsWithRange($encapsulates)->shouldBe(true);
    }

    function it_tells_you_how_many_days_are_in_a_week()
    {
        $this->getDayCount()->shouldReturn(7);
    }

    function it_tells_you_how_many_days_are_in_a_day()
    {
        $this->beConstructedThrough('fromDateTime', [new \DateTime('2014-07-01'), new \DateTime('2014-07-01')]);
        $this->getDayCount()->shouldReturn(1);
    }
}
