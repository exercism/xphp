<?php

require "connect.php";

class ConnectTest extends PHPUnit\Framework\TestCase
{
    /**
     * Strip off the spaces which are only for readability.
     */
    private function makeBoard($lines)
    {
        return array_map(function ($line) {
            return str_replace(" ", "", $line);
        }, $lines);
    }

    public function testEmptyBoardHasNoWinner()
    {
        $lines = [
            ". . . . .",
            " . . . . .",
            "  . . . . .",
            "   . . . . .",
            "    . . . . ."
        ];
        $this->assertEquals(null, resultFor($this->makeBoard($lines)));
    }

    /**
     * @depends testEmptyBoardHasNoWinner
     */
    public function testOneByOneBoardBlack()
    {
        $lines = ["X"];
        $this->assertEquals("black", resultFor($this->makeBoard($lines)));
    }

    /**
     * @depends testEmptyBoardHasNoWinner
     */
    public function testOneByOneBoardWhite()
    {
        $lines = ["O"];
        $this->assertEquals("white", resultFor($this->makeBoard($lines)));
    }

    /**
     * @depends testOneByOneBoardBlack
     * @depends testOneByOneBoardWhite
     */
    public function testConvultedPath()
    {
        $lines = [
            ". X X . .",
            " X . X . X",
            "  . X . X .",
            "   . X X . .",
            "    O O O O O"
        ];
        $this->assertEquals("black", resultFor($this->makeBoard($lines)));
    }

    /**
     * @depends testConvultedPath
     */
    public function testRectangleWhiteWins()
    {
        $lines = [
            ". O . .",
            " O X X X",
            "  O O O .",
            "   X X O X",
            "    . O X ."
        ];
        $this->assertEquals("white", resultFor($this->makeBoard($lines)));
    }

    /**
     * @depends testConvultedPath
     */
    public function testRectangleBlackWins()
    {
        $lines = [
            ". O . .",
            " O X X X",
            "  O X O .",
            "   X X O X",
            "    . O X ."
        ];
        $this->assertEquals("black", resultFor($this->makeBoard($lines)));
    }

    /**
     * @depends testRectangleWhiteWins
     * @depends testRectangleBlackWins
     */
    public function testSpiralBlackWins()
    {
        $lines = [
            "OXXXXXXXX",
            "OXOOOOOOO",
            "OXOXXXXXO",
            "OXOXOOOXO",
            "OXOXXXOXO",
            "OXOOOXOXO",
            "OXXXXXOXO",
            "OOOOOOOXO",
            "XXXXXXXXO"
        ];
        $this->assertEquals("black", resultFor($this->makeBoard($lines)));
    }

    /**
     * @depends testRectangleWhiteWins
     * @depends testRectangleBlackWins
     */
    public function testSpiralNobodyWins()
    {
        $lines = [
            "OXXXXXXXX",
            "OXOOOOOOO",
            "OXOXXXXXO",
            "OXOXOOOXO",
            "OXOX.XOXO",
            "OXOOOXOXO",
            "OXXXXXOXO",
            "OOOOOOOXO",
            "XXXXXXXXO"
        ];
        $this->assertEquals(null, resultFor($this->makeBoard($lines)));
    }

    /**
     * @depends testSpiralBlackWins
     * @depends testSpiralNobodyWins
     */
    public function testIllegalDiagonalNobodyWins()
    {
        $lines = [
            "X O . .",
            " O X X X",
            "  O X O .",
            "   . O X .",
            "    X X O O"
        ];

        $this->assertEquals(null, resultFor($this->makeBoard($lines)));
    }
}
