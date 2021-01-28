<?php

function territory($board, $x, $y)
{
    validate($board, $x, $y);
    [ $black, $white, $none ] = territories($board);

    if (in_array([$x, $y], $black)) {
        return ['BLACK', getTerritory($black, [$x, $y])];
    }
    if (in_array([$x, $y], $white)) {
        return ['WHITE', getTerritory($white, [$x, $y])];
    }
    if (in_array([$x, $y], $none)) {
        return ['NONE', getTerritory($none, [$x, $y])];
    }

    // If it's a stone this is the correct response.
    return ['NONE', []];
}

function getTerritory($territories, $coord)
{
    $in = [$coord];
    for ($i = 0; $i < 2; $i++) {
        $in = array_reduce(
            $territories,
            function ($coords, $a) {
                if (in_array($a, $coords)) {
                    return $coords;
                }
                foreach ($coords as $c) {
                    [ $x, $y ] = $c;
                    if (
                        in_array(
                            $a,
                            [
                                [$x+1, $y],
                                [$x-1, $y],
                                [$x, $y+1],
                                [$x, $y-1],
                            ]
                        )
                    ) {
                        $coords[] = $a;
                        return $coords;
                    }
                }
                return $coords;
            },
            $in
        ); 
    }
    return $in;
}

function territories($board)
{
    // Pass over the board the length of the board times
    for ($i = 0; $i < strlen($board[0]); $i++) {

        // Pass over the board.
        for ($a = 0; $a < count($board); $a++) {
            for ($b = 0; $b < strlen($board[0]); $b++) {

                // If the space is something besides blank, make the adjacent spaces match
                // unless they are also something else.
                if ($board[$a][$b] !== ' ') {
                    $to = lcfirst($board[$a][$b]);
                    foreach (getAdjacentSpaces($a, $b, count($board), strlen($board[0])) as $space) {
                        $from = $board[$space[0]][$space[1]];
                        $board[$space[0]][$space[1]] = convertSpace($from, $to);
                    }
                }
            }
        }
    }

    $black = $white = $none = [];
    for ($a = 0; $a < count($board); $a++) {
        for ($b = 0; $b < strlen($board[0]); $b++) {
            switch ($board[$a][$b]) {
                case 'b':
                    $black[] = [$b, $a];
                    break;

                case 'w':
                    $white[] = [$b, $a];
                    break;

                case 'n':
                case ' ':
                    $none[] = [$b, $a];
                    break;

                default:
                    break;
            }
        }
    }

    return [$black, $white, $none];
}

function getAdjacentSpaces($x, $y, $mX, $mY)
{
    $spaces = [];
    if ($x - 1 >= 0) {
        $spaces[] = [$x - 1, $y];
    }
    if ($x + 1 < $mX) {
        $spaces[] = [$x + 1, $y];
    }
    if ($y - 1 >= 0) {
        $spaces[] = [$x, $y - 1];
    }
    if ($y + 1 < $mY) {
        $spaces[] = [$x, $y + 1];
    }
    return $spaces;
}

function convertSpace($from, $to)
{
    // Simple, if the original is blank, it can just take the new value.
    if ($from === ' ') {
        return $to;
    }

    // capital letters are stones and shouldn't be changed.
    if (in_array($from, ['B', 'W'])) {
        return $from;
    }

    // If they're set to none or they don't match, set it to 'n'
    if ($from === 'n' || $from !== $to) {
        return 'n';
    }

    // Otherwise leave it the way it is.
    return $from;
}

function validate($board, $x, $y)
{
    $width = strlen($board[0]);
    $height = count($board);
    if ($x >= $width || $y >= $height || $x < 0 || $y < 0) {
        throw new \Exception;
    }
}
