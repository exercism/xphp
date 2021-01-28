<?php

class Scale
{
    const ASCENDING_INTERVALS = ["m", "M", "A"];
    const CHROMATIC_SCALE = ['C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B'];
    const FLAT_CHROMATIC_SCALE = ["C", "Db", "D", "Eb", "E", "F", "Gb", "G", "Ab", "A", "Bb","B"];
    const FLAT_KEYS = ["F", "Bb", "Eb", "Ab", "Db", "Gb", "d", "g", "c", "f", "bb", "eb"];

    public $tonic;
    public $scaleName;
    public $pattern;
    public $chromaticScale;
    public $name;
    public $pitches;

    public function __construct($tonic, $scaleName, $pattern = null)
    {
        $this->tonic = ucfirst($tonic);
        $this->scaleName = $scaleName;
        $this->pattern = $pattern;
        $this->chromaticScale = in_array($tonic, self::FLAT_KEYS) ? self::FLAT_CHROMATIC_SCALE : self::CHROMATIC_SCALE;
        $this->name = "{$this->tonic} {$this->scaleName}";
        $this->pitches = $this->pitches();
    }

    private function pitches() : array
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

    private function reorderChromaticScale() : array
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
