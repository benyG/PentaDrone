<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Export to HTML
 */
class ExportHtml extends ExportBase
{
    // Export
    public function export()
    {
        global $ExportFileName;
        if (!Config("DEBUG") && ob_get_length()) {
            ob_end_clean();
        }
        header('Content-Type: text/html' . ((Config("PROJECT_CHARSET") != '') ? '; charset=' . Config("PROJECT_CHARSET") : ''));
        header('Content-Disposition: attachment; filename=' . $ExportFileName . '.html');
        echo $this->Text;
    }
}
