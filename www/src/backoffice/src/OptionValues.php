<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Class option values
 */
class OptionValues
{
    public $Values = [];

    // Constructor
    public function __construct($ar = null)
    {
        if (is_array($ar)) {
            $this->Values = $ar;
        }
    }

    // Add value
    public function add($value)
    {
        $this->Values[] = $value;
    }

    // Convert to HTML
    public function toHtml(callable $fn = null)
    {
        $fn = $fn ?? PROJECT_NAMESPACE . "OptionsHtml";
        if (is_callable($fn)) {
            return $fn($this->Values);
        }
        return $this->__toString();
    }

    // Convert to string (MUST return a string value)
    public function __toString()
    {
        return implode(Config("OPTION_SEPARATOR"), $this->Values);
    }
}
