<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Export to email
 */
class ExportEmail extends ExportBase
{
    // Table border styles
    protected $cellStyles = "border: 1px solid #dddddd; padding: 5px;";

    // Table header
    public function exportTableHeader()
    {
        $this->Text .= "<table style=\"border-collapse: collapse;\">"; // Use inline style for Gmail
    }

    // Cell styles
    protected function cellStyles($fld, $useStyle = true)
    {
        $fld->CellAttrs->prepend("style", $this->cellStyles, ";"); // Use inline style for Gmail
        return ($useStyle && Config("EXPORT_CSS_STYLES")) ? $fld->cellStyles() : "";
    }

    // Export a field
    public function exportField(&$fld)
    {
        if (!$fld->Exportable) {
            return;
        }
        $this->FldCnt++;
        $exportValue = $fld->exportValue();
        if ($fld->ExportFieldImage && $fld->ViewTag == "IMAGE") {
            if ($fld->ImageResize) {
                $exportValue = GetFileImgTag($fld, $fld->getTempImage());
            } elseif ($fld->ExportHrefValue != "" && is_object($fld->Upload)) {
                if (!EmptyValue($fld->Upload->DbValue)) {
                    $exportValue = GetFileATag($fld, $fld->ExportHrefValue);
                }
            }
        } elseif ($fld->ExportFieldImage && $fld->ExportHrefValue != "") { // Export custom view tag
            $exportValue = $fld->ExportHrefValue;
        }
        if ($this->Horizontal) {
            $this->exportValueEx($fld, $exportValue);
        } else { // Vertical, export as a row
            $this->RowCnt++;
            $this->Text .= "<tr class=\"" . (($this->FldCnt % 2 == 1) ? "ew-export-table-row" : "ew-export-table-alt-row") . "\">" .
                "<td" . $this->cellStyles($fld) . ">" . $fld->exportCaption() . "</td>";
            $this->Text .= "<td" . $this->cellStyles($fld) . ">" . $exportValue . "</td></tr>";
        }
    }

    // Export
    public function export()
    {
        if (!Config("DEBUG") && ob_get_length()) {
            ob_end_clean();
        }
        echo $this->Text;
    }

    // Destructor
    public function __destruct()
    {
        DeleteTempImages();
    }
}
