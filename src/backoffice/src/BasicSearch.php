<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Basic Search class
 */
class BasicSearch
{
    public $TableVar = "";
    public $BasicSearchAnyFields;
    public $Keyword = "";
    public $KeywordDefault = "";
    public $Type = "";
    public $TypeDefault = "";
    protected $Prefix = "";

    // Constructor
    public function __construct($tblvar)
    {
        $this->BasicSearchAnyFields = Config("BASIC_SEARCH_ANY_FIELDS");
        $this->TableVar = $tblvar;
        $this->Prefix = PROJECT_NAME . "_" . $tblvar . "_";
    }

    // Session variable name
    protected function getSessionName($suffix)
    {
        return $this->Prefix . $suffix;
    }

    // Load default
    public function loadDefault()
    {
        $this->Keyword = $this->KeywordDefault;
        $this->Type = $this->TypeDefault;
        if (!isset($_SESSION[$this->getSessionName(Config("TABLE_BASIC_SEARCH_TYPE"))]) && $this->TypeDefault != "") { // Save default to session
            $this->setType($this->TypeDefault);
        }
    }

    // Unset session
    public function unsetSession()
    {
        Session()->delete($this->getSessionName(Config("TABLE_BASIC_SEARCH_TYPE")))
            ->delete($this->getSessionName(Config("TABLE_BASIC_SEARCH")));
    }

    // Isset session
    public function issetSession()
    {
        return isset($_SESSION[$this->getSessionName(Config("TABLE_BASIC_SEARCH"))]);
    }

    // Set keyword
    public function setKeyword($v, $save = true)
    {
        if (Config("REMOVE_XSS")) {
            $v = RemoveXss($v);
        }
        $this->Keyword = $v;
        if ($save) {
            $_SESSION[$this->getSessionName(Config("TABLE_BASIC_SEARCH"))] = $v;
        }
    }

    // Set type
    public function setType($v, $save = true)
    {
        if (Config("REMOVE_XSS")) {
            $v = RemoveXss($v);
        }
        $this->Type = $v;
        if ($save) {
            $_SESSION[$this->getSessionName(Config("TABLE_BASIC_SEARCH_TYPE"))] = $v;
        }
    }

    // Save
    public function save()
    {
        $_SESSION[$this->getSessionName(Config("TABLE_BASIC_SEARCH"))] = $this->Keyword;
        $_SESSION[$this->getSessionName(Config("TABLE_BASIC_SEARCH_TYPE"))] = $this->Type;
    }

    // Get keyword
    public function getKeyword()
    {
        return Session($this->getSessionName(Config("TABLE_BASIC_SEARCH")));
    }

    // Get type
    public function getType()
    {
        return Session($this->getSessionName(Config("TABLE_BASIC_SEARCH_TYPE")));
    }

    // Get type name
    public function getTypeName()
    {
        global $Language;
        $typ = $this->getType();
        switch ($typ) {
            case "=":
                return $Language->phrase("QuickSearchExact");
            case "AND":
                return $Language->phrase("QuickSearchAll");
            case "OR":
                return $Language->phrase("QuickSearchAny");
            default:
                return $Language->phrase("QuickSearchAuto");
        }
    }

    // Get short type name
    public function getTypeNameShort()
    {
        global $Language;
        $typ = $this->getType();
        switch ($typ) {
            case "=":
                $typname = $Language->phrase("QuickSearchExactShort");
                break;
            case "AND":
                $typname = $Language->phrase("QuickSearchAllShort");
                break;
            case "OR":
                $typname = $Language->phrase("QuickSearchAnyShort");
                break;
            default:
                $typname = $Language->phrase("QuickSearchAutoShort");
                break;
        }
        if ($typname != "") {
            $typname .= "&nbsp;";
        }
        return $typname;
    }

    // Get keyword list
    public function keywordList($default = false)
    {
        $searchKeyword = ($default) ? $this->KeywordDefault : $this->Keyword;
        $searchType = ($default) ? $this->TypeDefault : $this->Type;
        if ($searchKeyword != "") {
            $search = trim($searchKeyword);
            if ($searchType != "=") {
                $ar = [];
                // Match quoted keywords (i.e.: "...")
                if (preg_match_all('/"([^"]*)"/i', $search, $matches, PREG_SET_ORDER)) {
                    foreach ($matches as $match) {
                        $p = strpos($search, $match[0]);
                        $str = substr($search, 0, $p);
                        $search = substr($search, $p + strlen($match[0]));
                        if (strlen(trim($str)) > 0) {
                            $ar = array_merge($ar, explode(" ", trim($str)));
                        }
                        $ar[] = $match[1]; // Save quoted keyword
                    }
                }
                // Match individual keywords
                if (strlen(trim($search)) > 0) {
                    $ar = array_merge($ar, explode(" ", trim($search)));
                }
            } else {
                $ar = [$search];
            }
            return $ar;
        }
        return [];
    }

    // Load
    public function load()
    {
        $this->Keyword = $this->getKeyword();
        $this->Type = $this->getType();
    }
}
