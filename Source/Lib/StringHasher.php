<?php
namespace JSFramework\Lib;

class StringHasher
{
    const METHOD_MD5 = 1;
    const METHOD_SHA1 = 2;
    const METHOD_SHA256 = 4;

    private $salt = '';

    public function setSalt($newSalt)
    {
        $this->salt = $newSalt;
    }

    /**
     * Do a strong hash for given string with either MD5, SHA1 or SHA256
     *
     * Calculates salt from given presalt
     * Using the salt and length of original string calculates a strong hash
     *
     * @param string $stringToHash
     * @param string $preSaltSalt
     * @param int $method
     * @return string
     */
    public function strongHash($stringToHash, $preSaltSalt, $method = self::METHOD_MD5)
    {
        $stringLength = mb_strlen($stringToHash);
        $salt = $this->simpleHash(
            $this->plaseSaltAroundString($preSaltSalt, $this->salt),
            $method
        );
        $saltedString = $this->plaseSaltAroundString($stringToHash, $salt);
        $saltedString .= $stringLength;
        return $this->simpleHash($saltedString, $method);
    }

    /**
     * Split giben salt from middle and place given string between them
     *
     * @param string $string
     * @param string $salt
     * @return string
     */
    public function plaseSaltAroundString($string, $salt)
    {
        //divide the $salt into two strings from middle
        list($preSalt, $postSalt) = str_split($salt, floor( mb_strlen($salt) / 2) );

        return sprintf('%s%s%s', $preSalt, $string, $postSalt);
    }

    /**
     * Hash string with either MD5, SHA1 or SHA256
     *
     * @param string $stringToHash
     * @param const $method
     * @return string
     */
    public function simpleHash($stringToHash, $method = self::METHOD_MD5)
    {
        switch ($method){
            case self::METHOD_SHA1:
                $hashedString = sha1($stringToHash);
                break;
            case self::METHOD_SHA256:
                $hashedString = sha256($stringToHash);
                break;

            case self::METHOD_MD5:
            default:
                $hashedString = md5($stringToHash);
                break;
        }
        return $hashedString;
    }
}