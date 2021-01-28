<?php

namespace ExercismTest\Accumulate;

use PHPUnit\Framework\TestCase;
use function Exercism\Accumulate\accumulate;

class AccumulateTest extends TestCase
{
    public static function setUpBeforeClass() : void
    {
        $files = [
            '../src/accumulate.php',
            'Str.php',
            'StrSplitter.php',
            'Is.php',
        ];

        foreach ($files as $file) {
            require_once __DIR__ . '/' . $file;
        }
    }

    public function testAccumulateEmpty() : void
    {
        $accumulator = function ($value) {
            return $value ** 2;
        };

        $this->assertEquals([], accumulate([], $accumulator));
    }

    public function testAccumulateSquares() : void
    {
        $accumulator = function ($value) {
            return $value ** 2;
        };

        $this->assertEquals([1, 4, 9], accumulate([1, 2, 3], $accumulator));
    }

    public function testAccumulateUpperCases() : void
    {
        $accumulator = function ($string) {
            return mb_strtoupper($string);
        };

        $this->assertEquals(['HELLO', 'WORLD!'], accumulate(['Hello', 'World!'], $accumulator));
    }

    public function testAccumulateReversedStrings() : void
    {
        $accumulator = function ($string) {
            return strrev($string);
        };

        $this->assertEquals(['Hello', 'World!'], accumulate(['olleH', '!dlroW'], $accumulator));
    }

    public function testAccumulateConstants() : void
    {
        $accumulator = function () {
            return 1;
        };

        $this->assertEquals([1, 1], accumulate(['Hello', 'World!'], $accumulator));
    }

    public function testAccumulateWithinAccumulate() : void
    {
        $chars    = ['a', 'b', 'c'];
        $digits   = [1, 2, 3];
        $expected = [['a1', 'a2', 'a3'], ['b1', 'b2', 'b3'], ['c1', 'c2', 'c3']];

        $this->assertEquals(
            $expected,
            accumulate($chars, function ($char) use ($digits) {
                return accumulate($digits, function ($digit) use ($char) {
                    return $char . $digit;
                });
            })
        );
    }

    // Additional points for making the following tests pass

    public function testAccumulateUsingBuiltInFunction() : void
    {
        $this->assertEquals(['Hello', 'World!'], accumulate([" Hello\t", "\t World!\n "], 'trim'));
    }

    public function testAccumulateUsingStaticMethod() : void
    {
        $this->assertEquals([5, 6], accumulate(['Hello', 'World!'], 'ExercismTest\Accumulate\Str::len'));
    }

    public function testAccumulateUsingInvoke() : void
    {
        $this->assertEquals([['f', 'o', 'o']], accumulate(['foo'], new StrSplitter()));
    }

    public function testAccumulateUsingObjectAndArrayNotation() : void
    {
        $this->assertEquals([true, false, false], accumulate(['Yes', 0, []], [new Is(), 'truthy']));
    }
}
