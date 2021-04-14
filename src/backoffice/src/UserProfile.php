<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * User Profile Class
 */
class UserProfile
{
    public $Profile = [];
    public $Provider = "";
    public $Auth = "";

    // Constructor
    public function __construct()
    {
        $this->load();
    }

    // Has value
    public function has($name)
    {
        return array_key_exists($name, $this->Profile);
    }

    // Get value
    public function getValue($name)
    {
        if ($this->has($name)) {
            return $this->Profile[$name];
        }
        return null;
    }

    // Get all values
    public function getValues()
    {
        return $this->Profile;
    }

    // Get value (alias)
    public function get($name)
    {
        return $this->getValue($name);
    }

    // Set value
    public function setValue($name, $value)
    {
        $this->Profile[$name] = $value;
    }

    // Set value (alias)
    public function set($name, $value)
    {
        $this->setValue($name, $value);
    }

    // Set property // PHP
    public function __set($name, $value)
    {
        $this->setValue($name, $value);
    }

    // Get property // PHP
    public function __get($name)
    {
        return $this->getValue($name);
    }

    // Delete property
    public function delete($name)
    {
        if (array_key_exists($name, $this->Profile)) {
            unset($this->Profile[$name]);
        }
    }

    // Assign properties
    public function assign($input)
    {
        if (is_object($input)) {
            $this->assign(get_object_vars($input));
        } elseif (is_array($input)) {
            foreach ($input as $key => $value) { // Remove integer keys
                if (is_int($key)) {
                    unset($input[$key]);
                }
            }
            $input = array_filter($input, function ($val) {
                if (is_bool($val) || is_float($val) || is_int($val) || $val === null || is_string($val) && strlen($val) <= Config("DATA_STRING_MAX_LENGTH")) {
                    return true;
                }
                return false;
            });
            $this->Profile = array_merge($this->Profile, $input);
        }
    }

    // Check if System Admin
    protected function isSystemAdmin($usr)
    {
        global $Language;
        $adminUserName = Config("ENCRYPTION_ENABLED") ? PhpDecrypt(Config("ADMIN_USER_NAME"), Config("ENCRYPTION_KEY")) : Config("ADMIN_USER_NAME");
        return $usr == "" || $usr == $adminUserName || $usr == $Language->phrase("UserAdministrator");
    }

    // Load profile from session
    public function load()
    {
        if (isset($_SESSION[SESSION_USER_PROFILE])) {
            $this->loadProfile($_SESSION[SESSION_USER_PROFILE]);
        }
    }

    // Save profile to session
    public function save()
    {
        $_SESSION[SESSION_USER_PROFILE] = $this->profileToString();
    }

    // Load profile from string
    protected function loadProfile($profile)
    {
        $ar = unserialize(strval($profile));
        if (is_array($ar)) {
            $this->Profile = array_merge($this->Profile, $ar);
        }
    }

    // Write (var_dump) profile
    public function writeProfile()
    {
        var_dump($this->Profile);
    }

    // Clear profile
    protected function clearProfile()
    {
        $this->Profile = [];
    }

    // Clear profile (alias)
    public function clear()
    {
        $this->clearProfile();
    }

    // Profile to string
    protected function profileToString()
    {
        return serialize($this->Profile);
    }
}
