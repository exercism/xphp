<?php

namespace ExercismTest\Accumulate;

class StrSplitter
{
    public function __invoke($value)
    {
        return str_split($value);
    }
}
