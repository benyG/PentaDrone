<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Base class for export
 */
class ExportBase
{
    public $Table;
    public $Text;
    public $Line = "";
    public $Header = "";
    public $Style = "h"; // "v"(Vertical) or "h"(Horizontal)
    public $Horizontal = true; // Horizontal
    public $ExportCustom = false;
    protected $RowCnt = 0;
    protected $FldCnt = 0;

    // Constructor
    public function __construct(&$tbl = null, $style = "")
    {
        $this->Table = $tbl;
        $this->setStyle($style);
    }

    // Style
    public function setStyle($style)
    {
        $style = strtolower($style);
        if ($style == "v" || $style == "h") {
            $this->Style = $style;
        }
        $this->Horizontal = ($this->Style != "v");
    }

    // Field caption
    public function exportCaption(&$fld)
    {
        if (!$fld->Exportable) {
            return;
        }
        $this->FldCnt++;
        $this->exportValueEx($fld, $fld->exportCaption());
    }

    // Field value
    public function exportValue(&$fld)
    {
        $this->exportValueEx($fld, $fld->exportValue());
    }

    // Field aggregate
    public function exportAggregate(&$fld, $type)
    {
        if (!$fld->Exportable) {
            return;
        }
        $this->FldCnt++;
        if ($this->Horizontal) {
            global $Language;
            $val = "";
            if (in_array($type, ["TOTAL", "COUNT", "AVERAGE"])) {
                $val = $Language->phrase($type) . ": " . $fld->exportValue();
            }
            $this->exportValueEx($fld, $val);
        }
    }

    // Get meta tag for charset
    protected function charsetMetaTag()
    {
        return "<meta http-equiv=\"Content-Type\" content=\"text/html" . ((Config("PROJECT_CHARSET") != "") ? "; charset=" . Config("PROJECT_CHARSET") : "") . "\">\r\n";
    }

    // Table header
    public function exportTableHeader()
    {
        $this->Text .= "<table class=\"ew-export-table\">";
    }

    // Cell styles
    protected function cellStyles($fld, $useStyle = true)
    {
        return ($useStyle && Config("EXPORT_CSS_STYLES")) ? $fld->cellStyles() : "";
    }

    // Row styles
    protected function rowStyles($useStyle = true)
    {
        return ($useStyle && Config("EXPORT_CSS_STYLES")) ? $this->Table->rowStyles() : "";
    }

    // Export a value (caption, field value, or aggregate)
    protected function exportValueEx(&$fld, $val, $useStyle = true)
    {
        $this->Text .= "<td" . $this->cellStyles($fld, $useStyle) . ">";
        $this->Text .= strval($val);
        $this->Text .= "</td>";
    }

    // Begin a row
    public function beginExportRow($rowCnt = 0, $useStyle = true)
    {
        $this->RowCnt++;
        $this->FldCnt = 0;
        if ($this->Horizontal) {
            if ($rowCnt == -1) {
                $this->Table->CssClass = "ew-export-table-footer";
            } elseif ($rowCnt == 0) {
                $this->Table->CssClass = "ew-export-table-header";
            } else {
                $this->Table->CssClass = (($rowCnt % 2) == 1) ? "ew-export-table-row" : "ew-export-table-alt-row";
            }
            $this->Text .= "<tr" . $this->rowStyles($useStyle) . ">";
        }
    }

    // End a row
    public function endExportRow($rowCnt = 0)
    {
        if ($this->Horizontal) {
            $this->Text .= "</tr>";
        }
    }

    // Empty row
    public function exportEmptyRow()
    {
        $this->RowCnt++;
        $this->Text .= "<br>";
    }

    // Page break
    public function exportPageBreak()
    {
    }

    // Export a field
    public function exportField(&$fld)
    {
        if (!$fld->Exportable) {
            return;
        }
        $this->FldCnt++;
        $wrkExportValue = "";
        if ($fld->ExportFieldImage && $fld->ExportHrefValue != "" && is_object($fld->Upload)) { // Upload field
            if (!EmptyValue($fld->Upload->DbValue)) {
                $wrkExportValue = GetFileATag($fld, $fld->ExportHrefValue);
            }
        } else {
            $wrkExportValue = $fld->exportValue();
        }
        if ($this->Horizontal) {
            $this->exportValueEx($fld, $wrkExportValue);
        } else { // Vertical, export as a row
            $this->RowCnt++;
            $this->Text .= "<tr class=\"" . (($this->FldCnt % 2 == 1) ? "ew-export-table-row" : "ew-export-table-alt-row") . "\">" .
                "<td>" . $fld->exportCaption() . "</td>";
            $this->Text .= "<td" . $this->cellStyles($fld) . ">" . $wrkExportValue . "</td></tr>";
        }
    }

    // Table Footer
    public function exportTableFooter()
    {
        $this->Text .= "</table>";
    }

    // Add HTML tags
    public function exportHeaderAndFooter()
    {
        $header = "<html><head>\r\n";
        $header .= $this->charsetMetaTag();
        if (Config("EXPORT_CSS_STYLES") && Config("PROJECT_STYLESHEET_FILENAME") != "") {
            $header .= "<style type=\"text/css\">" . file_get_contents(Config("PROJECT_STYLESHEET_FILENAME")) . "</style>\r\n";
        }
        $header .= "</" . "head>\r\n<body>\r\n";
        $this->Text = $header . $this->Text . "</body></html>";
    }

    // Export
    public function export()
    {
        if (!Config("DEBUG") && ob_get_length()) {
            ob_end_clean();
        }
        if (SameText(Config("PROJECT_CHARSET"), "utf-8")) {
            Write("\xEF\xBB\xBF");
        }
        Write($this->Text);
    }
}
