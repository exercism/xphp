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

class Scale
{
    private const ASCENDING_INTERVALS = ["m", "M", "A"];
    private const CHROMATIC_SCALE = ['C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B'];
    private const FLAT_CHROMATIC_SCALE = ["C", "Db", "D", "Eb", "E", "F", "Gb", "G", "Ab", "A", "Bb","B"];
    private const FLAT_KEYS = ["F", "Bb", "Eb", "Ab", "Db", "Gb", "d", "g", "c", "f", "bb", "eb"];

    public $tonic;
    public $scaleName;
    public $pattern;
    public $chromaticScale;
    public $name;
    public $pitches;

    public function __construct(string $tonic, string $scaleName, string $pattern = null)
    {
        $this->tonic = ucfirst($tonic);
        $this->scaleName = $scaleName;
        $this->pattern = $pattern;
        $this->chromaticScale = in_array($tonic, self::FLAT_KEYS) ? self::FLAT_CHROMATIC_SCALE : self::CHROMATIC_SCALE;
        $this->name = "{$this->tonic} {$this->scaleName}";
        $this->pitches = $this->pitches();
    }

    private function pitches(): array
    {
        if (is_null($this->pattern)) {
            return $this->reorderChromaticScale();
        }
        $lastIndex = 0;
        $reorderedScale = $this->reorderChromaticScale();

        return array_reduce(
            str_split($this->pattern),
            function ($carry, $item) use (&$lastIndex, $reorderedScale) {
                $carry[] = $reorderedScale[$lastIndex];
                $lastIndex += array_search($item, self::ASCENDING_INTERVALS) + 1;
                return $carry;
            },
            []
        );
    }

    private function reorderChromaticScale(): array
    {
        if ($this->tonic == 'C') {
            return $this->chromaticScale;
        }
        $index = array_search($this->tonic, $this->chromaticScale);
        return array_merge(
            array_slice($this->chromaticScale, $index),
            array_slice($this->chromaticScale, 0, $index)
        );
    }
}
