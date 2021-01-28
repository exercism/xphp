<?php

class HighScores
{
    /**
     * The list of scores
     *
     * @var int[]
     */
    public $scores;

    /**
     * The last score in the list.
     *
     * @var integer
     */
    public $lastest;

    /**
     * The best score in a given list.
     *
     * @var integer
     */
    public $personalBest;

    /**
     * The top three scores in the list.
     *
     * @var int[]
     */
    public $personalTopThree;

    /**
     * The constructor, which takes in a list of scores.
     *
     * @param int[] $scores
     */
    public function __construct($scores)
    {
        $this->scores = $scores;
        $this->latest = $scores[count($scores)-1];
        $this->personalBest = max($scores);
        $t = $scores;
        rsort($t);
        $this->personalTopThree = array_slice($t, 0, 3);
    }
}
