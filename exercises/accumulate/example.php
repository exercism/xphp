<?php

namespace Exercism\Accumulate;

/**
 * Given the input array and operation returns an array
 * containing the result of applying that operation
 * to each element of the input array.
 *
 * @param array $input
 * @param callable $accumulator
 *
 * @return array
 */
function accumulate(array $input, callable $accumulator)
{
    $output = [];

    foreach ($input as $value) {
        $output[] = call_user_func($accumulator, $value);
    }

    return $output;
}
