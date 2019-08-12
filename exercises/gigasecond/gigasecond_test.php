<?php

class GigasecondTest extends PHPUnit\Framework\TestCase
{
    public static function setUpBeforeClass() : void
    {
        require_once 'gigasecond.php';
    }

    public function dateSetup($date) : DateTimeImmutable
    {
        $UTC = new DateTimeZone('UTC');
        return new DateTimeImmutable($date, $UTC);
    }

    public function testForDateOnlySpecificationOfTime() : void
    {
        $date = $this->dateSetup('2011-04-25');
        $gs = from($date);

        $this->assertSame('2043-01-01 01:46:40', $gs->format('Y-m-d H:i:s'));
        $this->assertInstanceOf(DateTimeImmutable::class, $gs);
    }

    public function testForDateOnlySpecificationOfTimeTwo() : void
    {
        $date = $this->dateSetup('1977-06-13');
        $gs = from($date);

        $this->assertSame('2009-02-19 01:46:40', $gs->format('Y-m-d H:i:s'));
        $this->assertInstanceOf(DateTimeImmutable::class, $gs);
    }

    public function testForDateOnlySpecificationOfTimeThree() : void
    {
        $date = $this->dateSetup('1959-07-19');
        $gs = from($date);

        $this->assertSame('1991-03-27 01:46:40', $gs->format('Y-m-d H:i:s'));
        $this->assertInstanceOf(DateTimeImmutable::class, $gs);
    }

    public function testFullTimeSpecified() : void
    {
        $date = $this->dateSetup('2015-01-24 22:00:00');
        $gs = from($date);

        $this->assertSame('2046-10-02 23:46:40', $gs->format('Y-m-d H:i:s'));
        $this->assertInstanceOf(DateTimeImmutable::class, $gs);
    }

    public function testFullTimeWithDayRollOver() : void
    {
        $date = $this->dateSetup('2015-01-24 23:59:59');
        $gs = from($date);

        $this->assertSame('2046-10-03 01:46:39', $gs->format('Y-m-d H:i:s'));
        $this->assertInstanceOf(DateTimeImmutable::class, $gs);
    }
}
