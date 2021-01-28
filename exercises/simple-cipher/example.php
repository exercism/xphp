<?php

class Cipher
{
    public $key;

    public $keyBytes;

    /**
     * @param $key
     */
    public function __construct(string $key = null, $keyLength = 100)
    {
        $this->keyIsValid($key);

        $this->key = $key;

        if (is_null($key)) {
            $this->keyBytes = [];
            for ($i = 0; $i < $keyLength; $i++) {
                $this->keyBytes[] = random_int(0, 25);
            }
            $this->key = $this->toString($this->keyBytes);
        } else {
            $this->keyBytes = $this->toBytes($key);
        }
    }

    private function keyIsValid($key)
    {
        if (preg_match('/[A-Z]/', $key)) {
            throw new InvalidArgumentException('The key should not contain capital letters.');
        }

        if (preg_match('/[0-9]/', $key)) {
            throw new InvalidArgumentException('The key should not contain numbers.');
        }

        if (empty($key) && !is_null($key)) {
            throw new InvalidArgumentException('The key should not be an empty string.');
        }
    }

    public function encode($plaintext)
    {
        $ciphertext = [];

        foreach ($this->toBytes($plaintext) as $idx => $byte) {
            $ciphertext[] = ($byte + $this->keyBytes[$idx % count($this->keyBytes)]) % 26;
        }

        return $this->toString($ciphertext);
    }

    public function decode($ciphertext)
    {
        $plaintext = [];

        foreach ($this->toBytes($ciphertext) as $idx => $byte) {
            $plaintext[] = ($byte - $this->keyBytes[$idx % count($this->keyBytes)]) % 26;
        }

        return $this->toString($plaintext);
    }

    private function toBytes($str) : array
    {
        return array_map(
            function ($i) {
                return ord($i)-97;
            },
            str_split($str)
        );
    }

    private function toString($arr) : string
    {
        return array_reduce(
            $arr,
            function ($carry, $i) {
                return $carry . chr($i+97);
            },
            ""
        );
    }
}
