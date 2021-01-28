<?php

class SimpleCipherTest extends PHPUnit\Framework\TestCase
{
    public static function setUpBeforeClass() : void
    {
        require_once 'simple-cipher.php';
    }

    public function testRandomCipherKeyIsLetters() : void
    {
        $cipher = new Cipher;
        $this->assertRegExp('/\A[a-z]+\z/', $cipher->key);
    }

    /**
     * Here we take advantage of the fact that plaintext of "aaa..." doesn't
     * output the key. This is a critical problem with shift ciphers, some
     * characters will always output the key verbatim.
     */
    public function testRandomKeyCipherEncode() : void
    {
        $cipher = new Cipher;
        $plaintext = 'aaaaaaaaaa';
        $this->assertEquals(substr($cipher->key, 0, 10), $cipher->encode($plaintext));
    }

    public function testRandomKeyCipherDecode() : void
    {
        $cipher = new Cipher;
        $plaintext = 'aaaaaaaaaa';
        $this->assertEquals($plaintext, $cipher->decode(substr($cipher->key, 0, 10)));
    }

    public function testRandomKeyCipherReversible() : void
    {
        $cipher = new Cipher;
        $plaintext = 'abcdefghij';
        $this->assertEquals($plaintext, $cipher->decode($cipher->encode($plaintext)));
    }

    public function testCipherWithCapsKey() : void
    {
        $this->expectException(\InvalidArgumentException::class);
        $cipher = new Cipher('ABCDEF');
    }

    public function testCipherWithNumericKey() : void
    {
        $this->expectException(\InvalidArgumentException::class);
        $cipher = new Cipher('12345');
    }

    public function testCipherWithEmptyKey() : void
    {
        $this->expectException(\InvalidArgumentException::class);
        $cipher = new Cipher('');
    }

    public function testCipherKeyIsAsSubmitted() : void
    {
        $cipher = new Cipher('abcdefghij');
        $this->assertEquals($cipher->key, 'abcdefghij');
    }

    public function testCipherEncode() : void
    {
        $cipher = new Cipher('abcdefghij');
        $plaintext = 'aaaaaaaaaa';
        $ciphertext = 'abcdefghij';
        $this->assertEquals($ciphertext, $cipher->encode($plaintext));
    }

    public function testCipherDecode() : void
    {
        $cipher = new Cipher('abcdefghij');
        $plaintext = 'aaaaaaaaaa';
        $ciphertext = 'abcdefghij';
        $this->assertEquals($plaintext, $cipher->decode($ciphertext));
    }

    public function testCipherReversible() : void
    {
        $cipher = new Cipher('abcdefghij');
        $plaintext = 'abcdefghij';
        $this->assertEquals($plaintext, $cipher->decode($cipher->encode($plaintext)));
    }

    public function testDoubleShiftEncode() : void
    {
        $cipher = new Cipher('abcdefghij');
        $plaintext = 'iamapandabear';
        $ciphertext = 'qayaeaagaciai';
        $this->assertEquals($ciphertext, (new Cipher('iamapandabear'))->encode($plaintext));
    }

    public function testCipherEncodeWrap() : void
    {
        $cipher = new Cipher('abcdefghij');
        $plaintext = 'zzzzzzzzzz';
        $ciphertext = 'zabcdefghi';
        $this->assertEquals($ciphertext, $cipher->encode($plaintext));
    }

    public function testShiftCipherEncode() : void
    {
        $cipher = new Cipher('dddddddddd');
        $plaintext = 'aaaaaaaaaa';
        $ciphertext = 'dddddddddd';
        $this->assertEquals($ciphertext, $cipher->encode($plaintext));
    }

    public function testShiftCipherDecode() : void
    {
        $cipher = new Cipher('dddddddddd');
        $plaintext = 'aaaaaaaaaa';
        $ciphertext = 'dddddddddd';
        $this->assertEquals($plaintext, $cipher->decode($ciphertext));
    }

    public function testShiftCipherReversible() : void
    {
        $cipher = new Cipher('dddddddddd');
        $plaintext = 'abcdefghij';
        $this->assertEquals($plaintext, $cipher->decode($cipher->encode($plaintext)));

    }
}
