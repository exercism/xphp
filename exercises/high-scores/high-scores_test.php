<?php

class HighScoresTest extends \PHPUnit\Framework\TestCase
{
    public static function setUpBeforeClass() : void
    {
        require_once 'high-scores.php';
    }

    public function testListOfScores() : void
    {
        $input = [30, 50, 20, 70];
        $this->assertEquals((new HighScores($input))->scores, [30, 50, 20, 70]);
    }

    public function testLatestScore() : void
    {
        $input = [100, 0, 90, 30];
        $this->assertEquals((new HighScores($input))->latest, 30);
    }

    public function testPersonalBest() : void
    {
        $input = [40, 100, 70];
        $this->assertEquals((new HighScores($input))->personalBest, 100);
    }

    public function testPersonalTopThreeFromAListOfScores() : void
    {
        $input = [10, 30, 90, 30, 100, 20, 10, 0, 30, 40, 40, 70, 70];
        $this->assertEquals((new HighScores($input))->personalTopThree, [100, 90, 70]);
    }

    public function testPersonalTopHighestToLowest() : void
    {
        $input = [20, 10, 30];
        $this->assertEquals((new HighScores($input))->personalTopThree, [30, 20, 10]);
    }

    public function testPersonalTopWhenThereIsATie() : void
    {
        $input = [40, 20, 40, 30];
        $this->assertEquals((new HighScores($input))->personalTopThree, [40, 40, 30]);
    }

    public function testPersonalTopWhenThereAreLessThan3() : void
    {
        $input = [30, 70];
        $this->assertEquals((new HighScores($input))->personalTopThree, [70, 30]);
    }

    public function testPersonalTopWhenThereIsOnlyOne() : void
    {
        $input = [40];
        $this->assertEquals((new HighScores($input))->personalTopThree, [40]);
    }
}
