<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Summary field class
 */
class SummaryField
{
    public $Name; // Field name
    public $FieldVar; // Field variable name
    public $Expression; // Field expression (used in SQL)
    public $SummaryType;
    public $SummaryCaption;
    public $SummaryViewAttrs;
    public $SummaryLinkAttrs;
    public $SummaryCurrentValues;
    public $SummaryViewValues;
    public $SummaryValues;
    public $SummaryValueCounts;
    public $SummaryGroupValues;
    public $SummaryGroupValueCounts;
    public $SummaryInitValue;
    public $SummaryRowSummary;
    public $SummaryRowCount;

    // Constructor
    public function __construct($fldvar, $fldname, $fldexpression, $smrytype)
    {
        $this->FieldVar = $fldvar;
        $this->Name = $fldname;
        $this->Expression = $fldexpression;
        $this->SummaryType = $smrytype;
    }

    // Summary view attributes
    public function summaryViewAttributes($i)
    {
        if (is_array($this->SummaryViewAttrs)) {
            if ($i >= 0 && $i < count($this->SummaryViewAttrs)) {
                $attrs = $this->SummaryViewAttrs[$i];
                if (is_array($attrs)) {
                    $att = new Attributes($attrs);
                    return $att->toString();
                }
            }
        }
        return "";
    }

    // Summary link attributes
    public function summaryLinkAttributes($i)
    {
        if (is_array($this->SummaryLinkAttrs)) {
            if ($i >= 0 && $i < count($this->SummaryLinkAttrs)) {
                $attrs = $this->SummaryLinkAttrs[$i];
                if (is_array($attrs)) {
                    $att = new Attributes($attrs);
                    if ($att["onclick"] != "" && $att["href"] == "") {
                        $att["href"] = "#";
                        $att.append("onclick", "return false;", ";");
                    }
                    return $att->toString();
                }
            }
        }
        return "";
    }
}
