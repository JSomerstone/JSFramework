<?php

namespace JSFramework\Test\Unit\Lib;

use JSFramework\Lib\StringHasher as StringHasher;

/**
 * Test class for Request.
 */
class StringHasherTest extends \JSFramework\Test\Unit\TestCase
{
    private $saltToSet = 'QWERTY123456';

    /**
     *
     * @var \JSFramework\Lib\StringHasher
     */
    public $object = null;

    public function setUp()
    {
        $this->object = new StringHasher();
        $this->object->setSalt($this->saltToSet);
    }

    /**
     * @test
     */
    public function simpleHashUsesMd5AsDefault()
    {
        $textToHash = 'This is the text to hash';
        $expected = md5($textToHash);

        $this->assertEquals(
            $expected,
            $this->object->simpleHash($textToHash)
        );
    }

    /**
     * @test
     */
    public function simpleHashUsesCorrectAlgorithm()
    {
        $textToHash = 'This is the text to hash';

        $expected = sha1($textToHash);
        $this->assertEquals(
            $expected,
            $this->object->simpleHash($textToHash, StringHasher::METHOD_SHA1)
        );

        $expected = md5($textToHash);
        $this->assertEquals(
            $expected,
            $this->object->simpleHash($textToHash, StringHasher::METHOD_MD5)
        );
    }

    /**
     * @test
     */
    public function saltManipulationWorks()
    {
        $salt =     'ABCDEF123456';
        $string =   '|----|';
        $expected = 'ABCDEF|----|123456';
        $actual = $this->object->plaseSaltAroundString($string, $salt);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function strongHashIsStrong()
    {
        $userName = 'Jack1234';
        $password = 'L3tMeIn!';
        $passwordLength = 8;

        $salt = md5('QWERTYJack1234123456');
        list($preSalt, $postSalt) = str_split($salt, floor( mb_strlen($salt) / 2 )) ;
        $string =  $preSalt . $password . $postSalt . $passwordLength;
        $expectedHash = md5($string);

        $actualHash = $this->object->strongHash($password, $userName);
        $this->assertEquals($expectedHash, $actualHash);
    }
}