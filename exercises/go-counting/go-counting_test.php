<?php

require "go-counting.php";
use PHPUnit\Framework\TestCase;

class GoCountingTest extends TestCase
{
    public function testBlackCornerTerritoryOn5x5Board()
    {
        [ $owner, $territory ] = territory(
            [
                "  B  ",
                " B B ",
                "B W B",
                " W W ",
                "  W  "
            ],
            0,
            1
        );
        $this->assertEquals($owner, "BLACK");
        $this->assertCoordinateSetEquals($territory, [[0, 0], [0, 1], [1, 0]]);
    }

    public function testWhiteCenterTerritoryOn5x5Board()
    {
        [ $owner, $territory ] = territory(
            [
                "  B  ",
                " B B ",
                "B W B",
                " W W ",
                "  W  "
            ],
            2,
            3
        );
        $this->assertEquals($owner, "WHITE");
        $this->assertCoordinateSetEquals($territory, [[2, 3]]);
    }

    public function testOpenCornerTerritoryOn5x5Board()
    {
        [ $owner, $territory ] = territory(
            [
                "  B  ",
                " B B ",
                "B W B",
                " W W ",
                "  W  "
            ],
            1,
            4
        );
        $this->assertEquals($owner, "NONE");
        $this->assertCoordinateSetEquals($territory, [[0, 3], [0, 4], [1, 4]]);
    }

    public function testAStoneAndNotATerritoryOn5x5Board()
    {
        [ $owner, $territory ] = territory(
            [
                "  B  ",
                " B B ",
                "B W B",
                " W W ",
                "  W  "
            ],
            1,
            1
        );
        $this->assertEquals($owner, "NONE");
        $this->assertCoordinateSetEquals($territory, []);
    }

    public function testInvalidBecauseXIsTooLowFor5x5Board()
    {
        $this->expectException(\Exception::class);
        territory(
            [
                "  B  ",
                " B B ",
                "B W B",
                " W W ",
                "  W  "
            ],
            -1,
            1
        );
    }

    public function testInvalidBecauseXIsTooHighFor5x5Board()
    {
        $this->expectException(\Exception::class);
        territory(
            [
                "  B  ",
                " B B ",
                "B W B",
                " W W ",
                "  W  "
            ],
            5,
            1
        );
    }

    public function testInvalidBecauseYIsTooLowFor5x5Board()
    {
        $this->expectException(\Exception::class);
        territory(
            [
                "  B  ",
                " B B ",
                "B W B",
                " W W ",
                "  W  "
            ],
            1,
            -1
        );
    }

    public function testInvalidBecauseYIsTooHighFor5x5Board()
    {
        $this->expectException(\Exception::class);
        territory(
            [
                "  B  ",
                " B B ",
                "B W B",
                " W W ",
                "  W  "
            ],
            1,
            5
        );
    }


    public function testOneTerritoryIsTheWholeBoard()
    {
        [ $black, $white, $none ] = territories([ " " ]);
        $this->assertEquals($black, []);
        $this->assertEquals($white, []);
        $this->assertEquals($none, [[0, 0]]);
    }

    public function testTwoTerritoryRectangularBoard()
    {
        [ $black, $white, $none ] = territories(
            [
                " BW ",
                " BW "
            ]
        );
        $this->assertEquals($black, [[0, 0], [0, 1]]);
        $this->assertEquals($white, [[3, 0], [3, 1]]);
        $this->assertEquals($none, []);
    }

    public function testTwoRegionRectangularBoard()
    {
        [ $black, $white, $none ] = territories([ " B " ]);
        $this->assertEquals($black, [[0, 0], [2, 0]]);
        $this->assertEquals($white, []);
        $this->assertEquals($none, []);
    }

    public function assertCoordinateSetEquals($a, $b)
    {
        $this->assertTrue(
            array_reduce($a, function ($c, $i) use ($b) { return $c && in_array($i, $b); }, true)
            && array_reduce($b, function ($c, $i) use ($a) { return $c && in_array($i, $a); }, true)
        );
    }
}
