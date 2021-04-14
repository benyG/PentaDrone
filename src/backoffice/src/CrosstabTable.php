<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Class for crosstab
 */
class CrosstabTable extends ReportTable
{
    // Column field related
    public $ColumnFieldName;
    public $ColumnDateSelection = false;
    public $ColumnDateType;

    // Summary fields
    public $SummaryFields = [];
    public $SummarySeparatorStyle = "unstyled";

    // Summary cells
    public $SummaryCellAttrs;
    public $SummaryViewAttrs;
    public $SummaryLinkAttrs;
    public $SummaryCurrentValues;
    public $SummaryViewValues;
    public $CurrentIndex = -1;

    // Constructor
    public function __construct()
    {
        parent::__construct();
    }

    // Summary cell attributes
    public function summaryCellAttributes($i)
    {
        if (is_array($this->SummaryCellAttrs)) {
            if ($i >= 0 && $i < count($this->SummaryCellAttrs)) {
                $attrs = $this->SummaryCellAttrs[$i];
                if (is_array($attrs)) {
                    $att = new Attributes($attrs);
                    return $att->toString();
                }
            }
        }
        return "";
    }

    // Summary view attributes
    public function summaryViewAttributes($i)
    {
        $att = "";
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

    // Render summary fields
    public function renderSummaryFields($idx)
    {
        global $ExportType, $CustomExportType;
        $html = "";
        $cnt = count($this->SummaryFields);
        for ($i = 0; $i < $cnt; $i++) {
            $smry = &$this->SummaryFields[$i];
            $vv = $smry->SummaryViewValues[$idx];
            if (@$smry->SummaryLinkAttrs[$idx]["onclick"] != "" || @$smry->SummaryLinkAttrs[$idx]["href"] != "") {
                $vv = "<a" . $smry->summaryLinkAttributes($idx) . ">" . $vv . "</a>";
            }
            $vv = "<span" . $smry->summaryViewAttributes($idx) . ">" . $vv . "</span>";
            if ($cnt > 0) {
                if ($ExportType == "" || $ExportType == "print" && $CustomExportType == "") {
                    $vv = "<li>" . $vv . "</li>";
                } elseif ($ExportType == "excel" && Config("USE_PHPEXCEL") || $ExportType == "word" && Config("USE_PHPWORD")) {
                    $vv .= "    ";
                } else {
                    $vv .= "<br>";
                }
            }
            $html .= $vv;
        }
        if ($cnt > 0 && ($ExportType == "" || $ExportType == "print" && $CustomExportType == "")) {
            $html = "<ul class=\"list-" . $this->SummarySeparatorStyle . " ew-crosstab-values\">" . $html . "</ul>";
        }
        return $html;
    }

    // Render summary types
    public function renderSummaryCaptions($typ = "")
    {
        global $Language, $ExportType, $CustomExportType;
        $html = "";
        $cnt = count($this->SummaryFields);
        if ($typ == "page") {
            return $Language->phrase("RptPageSummary");
        } elseif ($typ == "grand") {
            return $Language->phrase("RptGrandSummary");
        } else {
            for ($i = 0; $i < $cnt; $i++) {
                $smry = &$this->SummaryFields[$i];
                $st = $smry->SummaryCaption;
                $fld = $this->Fields[$smry->Name];
                $caption = $fld->caption();
                if ($caption != "") {
                    $st = $caption . " (" . $st . ")";
                }
                if ($cnt > 0) {
                    if ($ExportType == "" || $ExportType == "print" && $CustomExportType == "") {
                        $st = "<li>" . $st . "</li>";
                    } elseif ($ExportType == "excel" && Config("USE_PHPEXCEL") || $ExportType == "word" && Config("USE_PHPWORD")) {
                        $st .= "    ";
                    } else {
                        $st .= "<br>";
                    }
                }
                $html .= $st;
            }
            if ($cnt > 0 && ($ExportType == "" || $ExportType == "print" && $CustomExportType == "")) {
                $html = "<ul class=\"list-" . $this->SummarySeparatorStyle . " ew-crosstab-values\">" . $html . "</ul>";
            }
            return $html;
        }
    }
}
