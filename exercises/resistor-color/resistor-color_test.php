<?php

class ResistorColorTest extends PHPUnit\Framework\TestCase
{
    public static function setUpBeforeClass() : void
    {
        require_once 'resistor-color.php';
    }

    public function testBlackColorCode()
    {
        $this->assertEquals(colorCode("black"), 0);
    }

    public function testOrangeColorCode()
    {
        $this->assertEquals(colorCode("orange"), 3);
    }

    public function testWhiteColorCode()
    {
        $this->assertEquals(colorCode("white"), 9);
    }

    public function testColors()
    {
        $this->assertEquals(COLORS, [
            "black",
            "brown",
            "red",
            "orange",
            "yellow",
            "green",
            "blue",
            "violet",
            "grey",
            "white"
        ]);
    }
}
