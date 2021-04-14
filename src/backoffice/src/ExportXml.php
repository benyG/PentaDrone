<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Export to XML
 */
class ExportXml extends ExportBase
{
    public $XmlDoc;
    public $HasParent;

    // Constructor
    public function __construct(&$tbl = null, $style = "")
    {
        parent::__construct($tbl, $style);
        $this->XmlDoc = new XmlDocument(Config("XML_ENCODING"));
    }

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
        $this->HasParent = is_object($this->XmlDoc->documentElement());
        if (!$this->HasParent) {
            $this->XmlDoc->addRoot($this->Table->TableVar);
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
        if ($this->HasParent) {
            $this->XmlDoc->addRow($this->Table->TableVar);
        } else {
            $this->XmlDoc->addRow();
        }
    }

    // End a row
    public function endExportRow($rowCnt = 0)
    {
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
                $exportValue = $fld->Upload->DbValue;
            } else {
                $exportValue = $fld->exportValue();
            }
            if ($exportValue === null) {
                $exportValue = "<Null>";
            }
            $this->XmlDoc->addField($fld->Param, $exportValue);
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
        global $Response;
        //global $ExportFileName;
        if (!Config("DEBUG") && ob_get_length()) {
            ob_end_clean();
        }
        $Response = $Response->withHeader("Content-Type", "text/xml");
        //$Response = $Response->withHeader("Content-Disposition", "attachment; filename=" . $ExportFileName . ".xml");
        Write($this->XmlDoc->xml());
    }
}
