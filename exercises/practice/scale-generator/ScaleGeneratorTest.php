<?php

/*
 * By adding type hints and enabling strict type checking, code can become
 * easier to read, self-documenting and reduce the number of potential bugs.
 * By default, type declarations are non-strict, which means they will attempt
 * to change the original type to match the type specified by the
 * type-declaration.
 *
 * In other words, if you pass a string to a function requiring a float,
 * it will attempt to convert the string value to a float.
 *
 * To enable strict mode, a single declare directive must be placed at the top
 * of the file.
 * This means that the strictness of typing is configured on a per-file basis.
 * This directive not only affects the type declarations of parameters, but also
 * a function's return type.
 *
 * For more info review the Concept on strict type checking in the PHP track
 * <link>.
 *
 * To disable strict typing, comment out the directive below.
 */

declare(strict_types=1);

class ScaleGeneratorTest extends PHPUnit\Framework\TestCase
{
    public static function setUpBeforeClass(): void
    {
        require_once 'ScaleGenerator.php';
    }

    public function testNamingScale(): void
    {
        $chromatic = new Scale('c', "chromatic");
        $expected = 'C chromatic';
        $actual = $chromatic->name;
        $this->assertEquals($expected, $actual);
    }

    public function testChromaticScale(): void
    {
        $chromatic = new Scale('C', "chromatic");
        $expected = ["C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B"];
        $actual = $chromatic->pitches;
        $this->assertEquals($expected, $actual);
    }

    public function testAnotherChromaticScale(): void
    {
        $chromatic = new Scale("F", "chromatic");
        $expected = ["F", "Gb", "G", "Ab", "A", "Bb", "B", "C", "Db", "D", "Eb", "E"];
        $actual = $chromatic->pitches;
        $this->assertEquals($expected, $actual);
    }

    public function testNamingMajorScale(): void
    {
        $major = new Scale('G', "major", 'MMmMMMm');
        $expected = 'G major';
        $actual = $major->name;
        $this->assertEquals($expected, $actual);
    }

    public function testMajorScale(): void
    {
        $major = new Scale('C', "major", 'MMmMMMm');
        $expected = ["C", "D", "E", "F", "G", "A", "B"];
        $actual = $major->pitches;
        $this->assertEquals($expected, $actual);
    }

    public function testAnotherMajorScale(): void
    {
        $major = new Scale('G', "major", 'MMmMMMm');
        $expected = ["G", "A", "B", "C", "D", "E", "F#"];
        $actual = $major->pitches;
        $this->assertEquals($expected, $actual);
    }

    public function testMinorScale(): void
    {
        $minor = new Scale('f#', "minor", 'MmMMmMM');
        $expected = ["F#", "G#", "A", "B", "C#", "D", "E"];
        $actual = $minor->pitches;
        $this->assertEquals($expected, $actual);
    }

    public function testAnotherMinorScale(): void
    {
        $minor = new Scale('bb', "minor", 'MmMMmMM');
        $expected = ["Bb", "C", "Db", "Eb", "F", "Gb", "Ab"];
        $actual = $minor->pitches;
        $this->assertEquals($expected, $actual);
    }

    public function testDorianMode(): void
    {
        $dorian = new Scale('d', "dorian", 'MmMMMmM');
        $expected = ["D", "E", "F", "G", "A", "B", "C"];
        $actual = $dorian->pitches;
        $this->assertEquals($expected, $actual);
    }

    public function testMixolydianMode(): void
    {
        $mixolydian = new Scale('Eb', "mixolydian", 'MMmMMmM');
        $expected = ["Eb", "F", "G", "Ab", "Bb", "C", "Db"];
        $actual = $mixolydian->pitches;
        $this->assertEquals($expected, $actual);
    }

    public function testLydianMode(): void
    {
        $lydian = new Scale('a', "lydian", 'MMMmMMm');
        $expected = ["A", "B", "C#", "D#", "E", "F#", "G#"];
        $actual = $lydian->pitches;
        $this->assertEquals($expected, $actual);
    }

    public function testPhrygianMode(): void
    {
        $phrygian = new Scale('e', "phrygian", 'mMMMmMM');
        $expected = ["E", "F", "G", "A", "B", "C", "D"];
        $actual = $phrygian->pitches;
        $this->assertEquals($expected, $actual);
    }

    public function testLocrianMode(): void
    {
        $locrian = new Scale('g', "locrian", 'mMMmMMM');
        $expected = ["G", "Ab", "Bb", "C", "Db", "Eb", "F"];
        $actual = $locrian->pitches;
        $this->assertEquals($expected, $actual);
    }

    public function testHarmonicMinor(): void
    {
        $harmonicMinor = new Scale('d', "harmonic_minor", 'MmMMmAm');
        $expected = ["D", "E", "F", "G", "A", "Bb", "Db"];
        $actual = $harmonicMinor->pitches;
        $this->assertEquals($expected, $actual);
    }

    public function testOctatonic(): void
    {
        $octatonic = new Scale('C', "octatonic", 'MmMmMmMm');
        $expected = ["C", "D", "D#", "F", "F#", "G#", "A", "B"];
        $actual = $octatonic->pitches;
        $this->assertEquals($expected, $actual);
    }

    public function testHexatonic(): void
    {
        $hexatonic = new Scale('Db', "hexatonic", 'MMMMMM');
        $expected = ["Db", "Eb", "F", "G", "A", "B"];
        $actual = $hexatonic->pitches;
        $this->assertEquals($expected, $actual);
    }

    public function testPentatonic(): void
    {
        $pentatonic = new Scale('A', "pentatonic", 'MMAMA');
        $expected = ["A", "B", "C#", "E", "F#"];
        $actual = $pentatonic->pitches;
        $this->assertEquals($expected, $actual);
    }

    public function testEnigmatic(): void
    {
        $enigmatic = new Scale('G', "enigma", 'mAMMMmM');
        $expected = ["G", "G#", "B", "C#", "D#", "F", "F#"];
        $actual = $enigmatic->pitches;
        $this->assertEquals($expected, $actual);
    }
}
