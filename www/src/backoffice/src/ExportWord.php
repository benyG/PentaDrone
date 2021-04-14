<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Export to Word
 */
class ExportWord extends ExportBase
{
    // Export
    public function export()
    {
        global $ExportFileName;
        if (!Config("DEBUG") && ob_get_length()) {
            ob_end_clean();
        }
        header('Content-Type: application/msword' . ((Config("PROJECT_CHARSET") != '') ? '; charset=' . Config("PROJECT_CHARSET") : ''));
        header('Content-Disposition: attachment; filename=' . $ExportFileName . '.doc');
        if (SameText(Config("PROJECT_CHARSET"), "utf-8")) {
            Write("\xEF\xBB\xBF");
        }
        Write($this->Text);
    }
}
