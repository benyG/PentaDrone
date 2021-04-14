<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Export to Excel
 */
class ExportReportExcel
{
    // Export
    public function __invoke($page, $html)
    {
        global $ExportFileName;
        $charset = Config("PROJECT_CHARSET");
        header("Content-Type: application/vnd.ms-excel" . ($charset ? "; charset=" . $charset : ""));
        header("Content-Disposition: attachment; filename=" . $ExportFileName . ".xls");
        echo $html;
        exit();
    }
}
