<?php

namespace spec\Thing;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Thing\DateRange;

class DateRangeSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('fromDateTime', [new \DateTime('2014-07-01'), new \DateTime('2014-07-07')]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Thing\DateRange');
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
        $sameDateRange = DateRange::fromDateTime(new \DateTime('2014-07-01'), new \DateTime('2014-07-07'));
        $this->equals($sameDateRange)->shouldBe(true);
    }

    function it_tests_for_equality_between_different_timezones()
    {
        $diffDateRange = DateRange::fromDateTime(new \DateTime('2014-07-01', new \DateTimeZone('Europe/London')), new \DateTime('2014-07-07'));
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
        $internal = DateRange::fromDateTime(new \DateTime('2014-07-03'), new \DateTime('2014-07-05'));
        $this->overlapsWithRange($internal)->shouldBe(true);

        $before = DateRange::fromDateTime(new \DateTime('2014-06-03'), new \DateTime('2014-06-30'));
        $this->overlapsWithRange($before)->shouldBe(false);

        $after = DateRange::fromDateTime(new \DateTime('2014-07-10'), new \DateTime('2014-07-30'));
        $this->overlapsWithRange($after)->shouldBe(false);

        $startDuring = DateRange::fromDateTime(new \DateTime('2014-07-04'), new \DateTime('2014-07-30'));
        $this->overlapsWithRange($startDuring)->shouldBe(true);

        $endDuring = DateRange::fromDateTime(new \DateTime('2014-06-10'), new \DateTime('2014-07-03'));
        $this->overlapsWithRange($endDuring)->shouldBe(true);

        $encapsulates = DateRange::fromDateTime(new \DateTime('2014-06-10'), new \DateTime('2014-08-03'));
        $this->overlapsWithRange($encapsulates)->shouldBe(true);
    }
}
