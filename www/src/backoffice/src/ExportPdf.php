<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Class for export to PDF
 */
class ExportPdf extends ExportBase
{
    public static $StreamOptions = ["Attachment" => 1]; // 0 to open in browser, 1 to download

    // Table header
    public function exportTableHeader()
    {
        $this->Text .= "<table class=\"ew-table\">\r\n";
    }

    // Export a value (caption, field value, or aggregate)
    protected function exportValueEx(&$fld, $val, $useStyle = true)
    {
        $wrkVal = strval($val);
        $wrkVal = "<td" . ($useStyle && Config("EXPORT_CSS_STYLES") ? $fld->cellStyles() : "") . ">" . $wrkVal . "</td>\r\n";
        $this->Line .= $wrkVal;
        $this->Text .= $wrkVal;
    }

    // Begin a row
    public function beginExportRow($rowCnt = 0, $useStyle = true)
    {
        $this->FldCnt = 0;
        if ($this->Horizontal) {
            if ($rowCnt == -1) {
                $this->Table->CssClass = "ew-table-footer";
            } elseif ($rowCnt == 0) {
                $this->Table->CssClass = "ew-table-header";
            } else {
                $this->Table->CssClass = (($rowCnt % 2) == 1) ? "ew-table-row" : "ew-table-alt-row";
            }
            $this->Line = "<tr" . ($useStyle && Config("EXPORT_CSS_STYLES") ? $this->Table->rowStyles() : "") . ">";
            $this->Text .= $this->Line;
        }
    }

    // End a row
    public function endExportRow($rowCnt = 0)
    {
        if ($this->Horizontal) {
            $this->Line .= "</tr>";
            $this->Text .= "</tr>";
            $this->Header = $this->Line;
        }
    }

    // Page break
    public function exportPageBreak()
    {
        if ($this->Horizontal) {
            $this->Text .= "</table>\r\n"; // End current table
            $this->Text .= "<p style=\"page-break-after:always;\">&nbsp;</p>\r\n"; // Page break
            $this->Text .= "<table class=\"ew-table ew-table-border\">\r\n"; // New page header
            $this->Text .= $this->Header;
        }
    }

    // Export a field
    public function exportField(&$fld)
    {
        if (!$fld->Exportable) {
            return;
        }
        $exportValue = $fld->exportValue();
        if ($fld->ExportFieldImage && $fld->ViewTag == "IMAGE") {
            $exportValue = GetFileImgTag($fld, $fld->getTempImage());
        } elseif ($fld->ExportFieldImage && $fld->ExportHrefValue != "") { // Export custom view tag
            $exportValue = GetFileImgTag($fld, $fld->ExportHrefValue);
        } else {
            $exportValue = str_replace("<br>", "\r\n", $exportValue);
            $exportValue = strip_tags($exportValue);
            $exportValue = str_replace("\r\n", "<br>", $exportValue);
        }
        if ($this->Horizontal) {
            $this->exportValueEx($fld, $exportValue);
        } else { // Vertical, export as a row
            $this->FldCnt++;
            $fld->CellCssClass = ($this->FldCnt % 2 == 1) ? "ew-table-row" : "ew-table-alt-row";
            $this->Text .= "<tr><td" . (Config("EXPORT_CSS_STYLES") ? $fld->cellStyles() : "") . ">" . $fld->exportCaption() . "</td>";
            $this->Text .= "<td" . (Config("EXPORT_CSS_STYLES") ? $fld->cellStyles() : "") . ">" .
                $exportValue . "</td></tr>";
        }
    }

    // Get style tag
    public static function styleTag()
    {
        $pdfcss = Config("PDF_STYLESHEET_FILENAME");
        if ($pdfcss != "") {
            $path = FullUrl(GetUrl($pdfcss));
            $content = file_get_contents($path);
            if ($content) {
                return "<style type=\"text/css\">" . $content . "</style>\r\n";
            }
        }
        return "";
    }

    // Add HTML tags
    public function exportHeaderAndFooter()
    {
        $header = "<html><head>\r\n";
        $header .= $this->charsetMetaTag();
        $header .= self::styleTag();
        $header .= "</" . "head>\r\n<body>\r\n";
        $this->Text = $header . $this->Text . "</body></html>";
    }

    // Export
    public function export()
    {
        global $ExportFileName;
        @ini_set("memory_limit", Config("PDF_MEMORY_LIMIT"));
        set_time_limit(Config("PDF_TIME_LIMIT"));
        $txt = $this->Text;
        if (Config("DEBUG")) {
            $txt = str_replace("</body>", GetDebugMessage() . "</body>", $txt);
        }
        $dompdf = new \Dompdf\Dompdf(["pdf_backend" => "CPDF"]);
        $dompdf->load_html($txt);
        $dompdf->set_paper($this->Table->ExportPageSize, $this->Table->ExportPageOrientation);
        $dompdf->render();
        if (!Config("DEBUG") && ob_get_length()) {
            ob_end_clean();
        }
        $dompdf->stream($ExportFileName, self::$StreamOptions);
        DeleteTempImages();
    }

    // Destructor
    public function __destruct()
    {
        DeleteTempImages();
    }
}
