<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * LDAP class
 */
class LdapConn
{
    public $Conn; // LDAP server connection
    public $Dn = ""; // Default Distinguished Name, e.g. uid={username},ou=users,dc=demo,dc=com, "{username}" will be replaced by inputted user name
    public $Host = "";
    public $Port = 389;
    public $Options = [LDAP_OPT_PROTOCOL_VERSION => 3, LDAP_OPT_REFERRALS => 0];
    public $User = "";
    protected $Bind = false;
    protected $Auth = false;

    // Constructor
    public function __construct($hostname = "", $port = 0, $options = null)
    {
        if (function_exists("ldap_connect")) {
            if ($hostname) {
                $this->Host = $hostname;
            }
            if ($port > 0) {
                $this->Port = $port;
            }
            if (is_array($options)) {
                $this->Options = $options + $this->Options;
            }
            $this->Conn = ldap_connect($this->Host, $this->Port);
            if (is_array($this->Options)) {
                foreach ($this->Options as $key => $value) {
                    if (!ldap_set_option($this->Conn, $key, $value)) {
                        throw new \Exception("Unable to set LDAP option: " . $key);
                    }
                }
            }
        } else {
            throw new \Exception("LDAP support in PHP is not enabled. To install, see http://php.net/manual/en/ldap.installation.php.");
        }
    }

    // Bind an user
    public function bind(&$user, &$password)
    {
        $this->User = $user;
        $ldaprdn = ($this->Dn) ? str_replace("{username}", $user, $this->Dn) : $user;
        $this->Bind = @ldap_bind($this->Conn, $ldaprdn, $password);
        if ($this->Bind) {
            $this->Auth = $this->ldapValidated($user, $password);
            return $this->Auth;
        }
        return false;
    }

    // Is authenticated
    public function isAuthenticated()
    {
        return $this->Auth;
    }

    // Get last error
    public function getLastError()
    {
        return ldap_errno($this->Conn) . ": " . ldap_error($this->Conn);
    }

    // Search
    public function search($searchDn, $filter, $attributes = [])
    {
        if ($this->Bind) {
            $search = ldap_search($this->Conn, $searchDn, $filter, $attributes);
            if (!$search) {
                return false;
            }
            return ldap_get_entries($this->Conn, $search);
        }
        return false;
    }

    // Close/Unbind
    public function close()
    {
        ldap_close($this->Conn);
    }

    // LDAP Validated event
    public function ldapValidated(&$usr, &$pwd)
    {
        // Do something (if any) after binding an user successfully
        return true; // Return true/false to validate the user
    }
}
