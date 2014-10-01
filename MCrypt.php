<?php

class MCrypt
{
    private $iv = 'a1b2c3d4e5f6890'; #Same as in JAVA
    private $key = 'abcdef0123456789'; #Same as in JAVA


    function __construct()
    {
    }


    function encrypt($str, $isBinary = false)
    {
        $iv = $this->iv;
        $str = $isBinary ? $str : utf8_decode($str);

        $td = mcrypt_module_open('rijndael-128', ' ', 'cbc', $iv);

        mcrypt_generic_init($td, $this->key, $iv);
        $encrypted = mcrypt_generic($td, $str);

        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);

        return $isBinary ? $encrypted : bin2hex($encrypted);
    }


    function decrypt($code, $isBinary = false)
    {
        $code = $isBinary ? $code : $this->hex2bin($code);
        $iv = $this->iv;

        $td = mcrypt_module_open('rijndael-128', ' ', 'cbc', $iv);

        mcrypt_generic_init($td, $this->key, $iv);
        $decrypted = mdecrypt_generic($td, $code);

        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);

        return $isBinary ? trim($decrypted) : utf8_encode(trim($decrypted));
    }

    protected function hex2bin($hexdata)
    {
        $bindata = '';

        for ($i = 0; $i < strlen($hexdata); $i += 2) {
            $bindata .= chr(hexdec(substr($hexdata, $i, 2)));
        }

        return $bindata;
    }

}
$mcrypt = new MCrypt();



echo $encrypted = $mcrypt->encrypt("mystrongpass");



echo $decrypted = $mcrypt->decrypt($encrypted);
