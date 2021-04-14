<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Form class
 */
class HttpForm
{
    public $Index;
    public $FormName = "";

    // Constructor
    public function __construct()
    {
        $this->Index = -1;
    }

    // Get form element name based on index
    protected function getIndexedName($name)
    {
        if ($this->Index < 0) {
            return $name;
        } else {
            return substr($name, 0, 1) . $this->Index . substr($name, 1);
        }
    }

    // Has value for form element
    public function hasValue($name)
    {
        $wrkname = $this->getIndexedName($name);
        if (preg_match('/^(fn_)?(x|o)\d*_/', $name) && $this->FormName != "") {
            if (Post($this->FormName . '$' . $wrkname) !== null) {
                return true;
            }
        }
        return Post($wrkname) !== null;
    }

    // Get value for form element
    public function getValue($name)
    {
        $wrkname = $this->getIndexedName($name);
        $value = Post($wrkname);
        if (preg_match('/^(fn_)?(x|o)\d*_/', $name) && $this->FormName != "") {
            $wrkname = $this->FormName . '$' . $wrkname;
            if (Post($wrkname) !== null) {
                $value = Post($wrkname);
            }
        }
        return $value;
    }
}
