<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Advanced Search class
 */
class AdvancedSearch
{
    public $TableVar;
    public $FieldParam;
    public $SearchValue; // Search value
    public $ViewValue = ""; // View value
    public $SearchOperator; // Search operator
    public $SearchCondition; // Search condition
    public $SearchValue2; // Search value 2
    public $ViewValue2 = ""; // View value 2
    public $SearchOperator2; // Search operator 2
    public $SearchValueDefault = ""; // Search value default
    public $SearchOperatorDefault = ""; // Search operator default
    public $SearchConditionDefault = ""; // Search condition default
    public $SearchValue2Default = ""; // Search value 2 default
    public $SearchOperator2Default = ""; // Search operator 2 default
    protected $Prefix = "";
    protected $Suffix = "";

    // Constructor
    public function __construct($tblvar, $fldparm)
    {
        $this->TableVar = $tblvar;
        $this->FieldParam = $fldparm;
        $this->Prefix = PROJECT_NAME . "_" . $tblvar . "_" . Config("TABLE_ADVANCED_SEARCH") . "_";
        $this->Suffix = "_" . $this->FieldParam;
    }

    // Set SearchValue
    public function setSearchValue($v)
    {
        if (Config("REMOVE_XSS")) {
            $v = RemoveXss($v);
        }
        $this->SearchValue = $v;
    }

    // Set SearchOperator
    public function setSearchOperator($v)
    {
        if ($this->isValidOperator($v)) {
            $this->SearchOperator = $v;
        }
    }

    // Set SearchCondition
    public function setSearchCondition($v)
    {
        if (Config("REMOVE_XSS")) {
            $v = RemoveXss($v);
        }
        $this->SearchCondition = $v;
    }

    // Set SearchValue2
    public function setSearchValue2($v)
    {
        if (Config("REMOVE_XSS")) {
            $v = RemoveXss($v);
        }
        $this->SearchValue2 = $v;
    }

    // Set SearchOperator2
    public function setSearchOperator2($v)
    {
        if ($this->isValidOperator($v)) {
            $this->SearchOperator2 = $v;
        }
    }

    // Unset session
    public function unsetSession()
    {
        Session()->delete($this->getSessionName("x"))
            ->delete($this->getSessionName("z"))
            ->delete($this->getSessionName("v"))
            ->delete($this->getSessionName("y"))
            ->delete($this->getSessionName("w"));
    }

    // Isset session
    public function issetSession()
    {
        return isset($_SESSION[$this->getSessionName("x")]) || isset($_SESSION[$this->getSessionName("y")]);
    }

    // Get values from array
    public function getFromArray($ar)
    {
        $parm = $this->FieldParam;
        $hasValue = false;
        if (array_key_exists("x_$parm", $ar)) {
            $this->setSearchValue($ar["x_$parm"]);
            $hasValue = true;
        } elseif (array_key_exists($parm, $ar)) { // Support SearchValue without "x_"
            $this->setSearchValue($ar[$parm]);
            $hasValue = true;
        }
        if (array_key_exists("z_$parm", $ar)) {
            $this->setSearchOperator($ar["z_$parm"]);
            $hasValue = true;
        }
        if (array_key_exists("v_$parm", $ar)) {
            $this->setSearchCondition($ar["v_$parm"]);
            $hasValue = true;
        }
        if (array_key_exists("y_$parm", $ar)) {
            $this->setSearchValue2($ar["y_$parm"]);
            $hasValue = true;
        }
        if (array_key_exists("w_$parm", $ar)) {
            $this->setSearchOperator2($ar["w_$parm"]);
            $hasValue = true;
        }
        return $hasValue;
    }

    // Get values from query string
    public function get()
    {
        $parm = $this->FieldParam;
        $hasValue = false;
        if (Get("x_$parm") !== null) {
            $this->setSearchValue(Get("x_$parm"));
            $hasValue = true;
        } elseif (Get($parm) !== null) { // Support SearchValue without "x_"
            $this->setSearchValue(Get($parm));
            $hasValue = true;
        }
        if (Get("z_$parm") !== null) {
            $this->setSearchOperator(Get("z_$parm"));
            $hasValue = true;
        }
        if (Get("v_$parm") !== null) {
            $this->setSearchCondition(Get("v_$parm"));
            $hasValue = true;
        }
        if (Get("y_$parm") !== null) {
            $this->setSearchValue2(Get("y_$parm"));
            $hasValue = true;
        }
        if (Get("w_$parm") !== null) {
            $this->setSearchOperator2(Get("w_$parm"));
            $hasValue = true;
        }
        return $hasValue;
    }

    // Get values from post
    public function post()
    {
        $parm = $this->FieldParam;
        $hasValue = false;
        if (Post("x_$parm") !== null) {
            $this->setSearchValue(Post("x_$parm"));
            $hasValue = true;
        } elseif (Post($parm) !== null) { // Support SearchValue without "x_"
            $this->setSearchValue(Post($parm));
            $hasValue = true;
        }
        if (Post("z_$parm") !== null) {
            $this->setSearchOperator(Post("z_$parm"));
            $hasValue = true;
        }
        if (Post("v_$parm") !== null) {
            $this->setSearchCondition(Post("v_$parm"));
            $hasValue = true;
        }
        if (Post("y_$parm") !== null) {
            $this->setSearchValue2(Post("y_$parm"));
            $hasValue = true;
        }
        if (Post("w_$parm") !== null) {
            $this->setSearchOperator2(Post("w_$parm"));
            $hasValue = true;
        }
        return $hasValue;
    }

    // Save to session
    public function save()
    {
        $fldVal = $this->SearchValue;
        if (is_array($fldVal)) {
            $fldVal = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal);
        }
        $fldVal2 = $this->SearchValue2;
        if (is_array($fldVal2)) {
            $fldVal2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal2);
        }
        if (Session($this->getSessionName("x")) != $fldVal) {
            $_SESSION[$this->getSessionName("x")] = $fldVal;
        }
        if (Session($this->getSessionName("y")) != $fldVal2) {
            $_SESSION[$this->getSessionName("y")] = $fldVal2;
        }
        if (Session($this->getSessionName("z")) != $this->SearchOperator) {
            $_SESSION[$this->getSessionName("z")] = $this->SearchOperator;
        }
        if (Session($this->getSessionName("v")) != $this->SearchCondition) {
            $_SESSION[$this->getSessionName("v")] = $this->SearchCondition;
        }
        if (Session($this->getSessionName("w")) != $this->SearchOperator2) {
            $_SESSION[$this->getSessionName("w")] = $this->SearchOperator2;
        }
    }

    // Load from session
    public function load()
    {
        $this->SearchValue = Session($this->getSessionName("x"));
        $this->SearchOperator = Session($this->getSessionName("z"));
        $this->SearchCondition = Session($this->getSessionName("v"));
        $this->SearchValue2 = Session($this->getSessionName("y"));
        $this->SearchOperator2 = Session($this->getSessionName("w"));
    }

    // Get value
    public function getValue($infix)
    {
        return Session($this->getSessionName($infix));
    }

    // Load default values
    public function loadDefault()
    {
        if ($this->SearchValueDefault != "") {
            $this->SearchValue = $this->SearchValueDefault;
        }
        if ($this->SearchOperatorDefault != "") {
            $this->SearchOperator = $this->SearchOperatorDefault;
        }
        if ($this->SearchConditionDefault != "") {
            $this->SearchCondition = $this->SearchConditionDefault;
        }
        if ($this->SearchValue2Default != "") {
            $this->SearchValue2 = $this->SearchValue2Default;
        }
        if ($this->SearchOperator2Default != "") {
            $this->SearchOperator2 = $this->SearchOperator2Default;
        }
    }

    // Convert to JSON
    public function toJson()
    {
        if ($this->SearchValue != "" || $this->SearchValue2 != "" || in_array($this->SearchOperator, ["IS NULL", "IS NOT NULL"]) || in_array($this->SearchOperator2, ["IS NULL", "IS NOT NULL"])) {
            return '"x' . $this->Suffix . '":"' . JsEncode($this->SearchValue) . '",' .
                '"z' . $this->Suffix . '":"' . JsEncode($this->SearchOperator) . '",' .
                '"v' . $this->Suffix . '":"' . JsEncode($this->SearchCondition) . '",' .
                '"y' . $this->Suffix . '":"' . JsEncode($this->SearchValue2) . '",' .
                '"w' . $this->Suffix . '":"' . JsEncode($this->SearchOperator2) . '"';
        } else {
            return "";
        }
    }

    // Session variable name
    protected function getSessionName($infix)
    {
        return $this->Prefix . $infix . $this->Suffix;
    }

    /**
     * Check if search operator is valid
     *
     * @param string $opr Search operator, e.g. '<', '>'
     * @return bool
     */
    protected function isValidOperator($opr)
    {
        return in_array($opr, ['=', '<>', '<', '<=', '>', '>=', 'LIKE', 'NOT LIKE', 'STARTS WITH', 'ENDS WITH', 'IS NULL', 'IS NOT NULL', 'BETWEEN']);
    }
}
