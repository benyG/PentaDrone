<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Export to CSV
 */
class ExportCsv extends ExportBase
{
    public $QuoteChar = "\"";
    public $Separator = ",";

    // Style
    public function setStyle($style)
    {
        $this->Horizontal = true;
    }

    // Table header
    public function exportTableHeader()
    {
    }

    // Export a value (caption, field value, or aggregate)
    protected function exportValueEx(&$fld, $val, $useStyle = true)
    {
        if ($fld->DataType != DATATYPE_BLOB) {
            if ($this->Line != "") {
                $this->Line .= $this->Separator;
            }
            $this->Line .= $this->QuoteChar . str_replace($this->QuoteChar, $this->QuoteChar . $this->QuoteChar, strval($val)) . $this->QuoteChar;
        }
    }

    // Begin a row
    public function beginExportRow($rowCnt = 0, $useStyle = true)
    {
        $this->Line = "";
    }

    // End a row
    public function endExportRow($rowCnt = 0)
    {
        $this->Line .= "\r\n";
        $this->Text .= $this->Line;
    }

    // Empty row
    public function exportEmptyRow()
    {
    }

    // Export a field
    public function exportField(&$fld)
    {
        if (!$fld->Exportable) {
            return;
        }
        if ($fld->UploadMultiple) {
            $this->exportValueEx($fld, $fld->Upload->DbValue);
        } else {
            $this->exportValue($fld);
        }
    }

    // Table Footer
    public function exportTableFooter()
    {
    }

    // Add HTML tags
    public function exportHeaderAndFooter()
    {
    }

    // Export
    public function export()
    {
        global $ExportFileName;
        if (!Config("DEBUG") && ob_get_length()) {
            ob_end_clean();
        }
        header('Content-Type: text/csv' . ((Config("PROJECT_CHARSET") != "") ? '; charset=' . Config("PROJECT_CHARSET") : ''));
        header('Content-Disposition: attachment; filename=' . $ExportFileName . '.csv');
        if (SameText(Config("PROJECT_CHARSET"), "utf-8")) {
            Write("\xEF\xBB\xBF");
        }
        Write($this->Text);
    }
}
