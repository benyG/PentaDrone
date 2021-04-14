<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Class for encryption/decryption with php-encryption
 */
class PhpEncryption
{
    protected $Key;

    // Constructor
    public function __construct($encodedKey, $password = "")
    {
        if ($password) { // Password protected key
            $key = \Defuse\Crypto\KeyProtectedByPassword::loadFromAsciiSafeString($encodedKey);
            $this->Key = $key->unlockKey($password);
        } else { // Random key
            $this->Key = \Defuse\Crypto\Key::loadFromAsciiSafeString($encodedKey);
        }
    }

    // Create random password protected key
    public static function CreateRandomPasswordProtectedKey($password)
    {
        $protectedKey = \Defuse\Crypto\KeyProtectedByPassword::createRandomPasswordProtectedKey($password);
        return $protectedKey->saveToAsciiSafeString();
    }

    // Create new random key without password
    public static function CreateNewRandomKey()
    {
        $key = \Defuse\Crypto\Key::createNewRandomKey();
        return $key->saveToAsciiSafeString();
    }

    // Encrypt with password
    public static function encryptWithPassword($plaintext, $password)
    {
        return \Defuse\Crypto\Crypto::encryptWithPassword($plaintext, $password);
    }

    // Decrypt with password
    public static function decryptWithPassword($plaintext, $password)
    {
        return \Defuse\Crypto\Crypto::decryptWithPassword($plaintext, $password);
    }

    // Encrypt
    public function encrypt($plaintext)
    {
        return \Defuse\Crypto\Crypto::encrypt($plaintext, $this->Key);
    }

    // Decrypt
    public function decrypt($plaintext)
    {
        return \Defuse\Crypto\Crypto::decrypt($plaintext, $this->Key);
    }
}
