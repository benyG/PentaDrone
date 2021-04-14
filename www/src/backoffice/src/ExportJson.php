<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Export to JSON
 */
class ExportJson extends ExportBase
{
    protected $Items;
    protected $Item;
    public $HasParent;

    // Style
    public function setStyle($style)
    {
    }

    // Field caption
    public function exportCaption(&$fld)
    {
    }

    // Field value
    public function exportValue(&$fld)
    {
    }

    // Field aggregate
    public function exportAggregate(&$fld, $type)
    {
    }

    // Get meta tag for charset
    protected function charsetMetaTag()
    {
    }

    // Table header
    public function exportTableHeader()
    {
        $this->HasParent = isset($this->Items);
        if ($this->HasParent) {
            if (is_array($this->Items)) {
                $this->Items[$this->Table->TableName] = [];
            } elseif (is_object($this->Items)) {
                $this->Items->{$this->Table->TableName} = [];
            }
        }
    }

    // Export a value (caption, field value, or aggregate)
    protected function exportValueEx(&$fld, $val, $useStyle = true)
    {
    }

    // Begin a row
    public function beginExportRow($rowCnt = 0, $useStyle = true)
    {
        if ($rowCnt <= 0) {
            return;
        }
        $this->Item = new \stdClass();
    }

    // End a row
    public function endExportRow($rowCnt = 0)
    {
        if ($rowCnt <= 0) {
            return;
        }
        if ($this->HasParent) {
            if (is_array($this->Items)) {
                $this->Items[$this->Table->TableName][] = $this->Item;
            } elseif (is_object($this->Items)) {
                $this->Items->{$this->Table->TableName}[] = $this->Item;
            }
        } else {
            if (is_array($this->Items)) {
                $this->Items[] = $this->Item;
            } elseif (is_object($this->Items)) {
                $this->Items = [$this->Items, $this->Item]; // Convert to array
            } else {
                $this->Items = $this->Item;
            }
        }
    }

    // Empty row
    public function exportEmptyRow()
    {
    }

    // Page break
    public function exportPageBreak()
    {
    }

    // Export a field
    public function exportField(&$fld)
    {
        if ($fld->Exportable && $fld->DataType != DATATYPE_BLOB) {
            if ($fld->UploadMultiple) {
                $this->Item->{$fld->Name} = $fld->Upload->DbValue;
            } else {
                $this->Item->{$fld->Name} = $fld->exportValue();
            }
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
        //global $ExportFileName;
        if (!Config("DEBUG") && ob_get_length()) {
            ob_end_clean();
        }

        //header('Content-Disposition: attachment; filename=' . $ExportFileName . '.json');
        WriteJson($this->Items, Config("DEBUG") ? JSON_PRETTY_PRINT : 0);
    }
}
