<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Class for table
 */
class DbTable extends DbTableBase
{
    public $CurrentMode = "view"; // Current mode
    public $UpdateConflict; // Update conflict
    public $EventName; // Event name
    public $EventCancelled; // Event cancelled
    public $CancelMessage; // Cancel message
    public $AllowAddDeleteRow = false; // Allow add/delete row
    public $ValidateKey = true; // Validate key
    public $DetailAdd; // Allow detail add
    public $DetailEdit; // Allow detail edit
    public $DetailView; // Allow detail view
    public $ShowMultipleDetails; // Show multiple details
    public $GridAddRowCount;
    public $CustomActions = []; // Custom action array

    // Constructor
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Check current action
     */

    // Display
    public function isShow()
    {
        return $this->CurrentAction == "show";
    }

    // Add
    public function isAdd()
    {
        return $this->CurrentAction == "add";
    }

    // Copy
    public function isCopy()
    {
        return $this->CurrentAction == "copy";
    }

    // Edit
    public function isEdit()
    {
        return $this->CurrentAction == "edit";
    }

    // Delete
    public function isDelete()
    {
        return $this->CurrentAction == "delete";
    }

    // Confirm
    public function isConfirm()
    {
        return $this->CurrentAction == "confirm";
    }

    // Overwrite
    public function isOverwrite()
    {
        return $this->CurrentAction == "overwrite";
    }

    // Cancel
    public function isCancel()
    {
        return $this->CurrentAction == "cancel";
    }

    // Grid add
    public function isGridAdd()
    {
        return $this->CurrentAction == "gridadd";
    }

    // Grid edit
    public function isGridEdit()
    {
        return $this->CurrentAction == "gridedit";
    }

    // Add/Copy/Edit/GridAdd/GridEdit
    public function isAddOrEdit()
    {
        return $this->isAdd() || $this->isCopy() || $this->isEdit() || $this->isGridAdd() || $this->isGridEdit();
    }

    // Insert
    public function isInsert()
    {
        return $this->CurrentAction == "insert";
    }

    // Update
    public function isUpdate()
    {
        return $this->CurrentAction == "update";
    }

    // Grid update
    public function isGridUpdate()
    {
        return $this->CurrentAction == "gridupdate";
    }

    // Grid insert
    public function isGridInsert()
    {
        return $this->CurrentAction == "gridinsert";
    }

    // Grid overwrite
    public function isGridOverwrite()
    {
        return $this->CurrentAction == "gridoverwrite";
    }

    // Import
    public function isImport()
    {
        return $this->CurrentAction == "import";
    }

    // Search
    public function isSearch()
    {
        return $this->CurrentAction == "search";
    }

    /**
     * Check last action
     */

    // Cancelled
    public function isCanceled()
    {
        return $this->LastAction == "cancel" && !$this->CurrentAction;
    }

    // Inline inserted
    public function isInlineInserted()
    {
        return $this->LastAction == "insert" && !$this->CurrentAction;
    }

    // Inline updated
    public function isInlineUpdated()
    {
        return $this->LastAction == "update" && !$this->CurrentAction;
    }

    // Grid updated
    public function isGridUpdated()
    {
        return $this->LastAction == "gridupdate" && !$this->CurrentAction;
    }

    // Grid inserted
    public function isGridInserted()
    {
        return $this->LastAction == "gridinsert" && !$this->CurrentAction;
    }

    /**
     * Inline Add/Copy/Edit row
     */

    // Inline-Add row
    public function isInlineAddRow()
    {
        return $this->isAdd() && $this->RowType == ROWTYPE_ADD;
    }

    // Inline-Copy row
    public function isInlineCopyRow()
    {
        return $this->isCopy() && $this->RowType == ROWTYPE_ADD;
    }

    // Inline-Edit row
    public function isInlineEditRow()
    {
        return $this->isEdit() && $this->RowType == ROWTYPE_EDIT;
    }

    // Inline-Add/Copy/Edit row
    public function isInlineActionRow()
    {
        return $this->isInlineAddRow() || $this->isInlineCopyRow() || $this->isInlineEditRow();
    }

    /**
     * Other methods
     */

    // Export return page
    public function exportReturnUrl()
    {
        $url = Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_EXPORT_RETURN_URL"));
        return ($url != "") ? $url : CurrentPageUrl();
    }

    public function setExportReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_EXPORT_RETURN_URL")] = $v;
    }

    // Records per page
    public function getRecordsPerPage()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_REC_PER_PAGE"));
    }

    public function setRecordsPerPage($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_REC_PER_PAGE")] = $v;
    }

    // Start record number
    public function getStartRecordNumber()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_START_REC"));
    }

    public function setStartRecordNumber($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_START_REC")] = $v;
    }

    // Search highlight name
    public function highlightName()
    {
        return $this->TableVar . "_Highlight";
    }

    // Search highlight value
    public function highlightValue($fld)
    {
        $kwlist = $this->BasicSearch->keywordList();
        if ($this->BasicSearch->Type == "") { // Auto, remove ALL "OR"
            $kwlist = array_diff($kwlist, ["OR"]);
        }
        $oprs = ["=", "LIKE", "STARTS WITH", "ENDS WITH"]; // Valid operators for highlight
        if (in_array($fld->AdvancedSearch->getValue("z"), $oprs)) {
            $akw = $fld->AdvancedSearch->getValue("x");
            if (strlen($akw) > 0) {
                $kwlist[] = $akw;
            }
        }
        if (in_array($fld->AdvancedSearch->getValue("w"), $oprs)) {
            $akw = $fld->AdvancedSearch->getValue("y");
            if (strlen($akw) > 0) {
                $kwlist[] = $akw;
            }
        }
        $src = $fld->getViewValue();
        if (count($kwlist) == 0) {
            return $src;
        }
        $pos1 = 0;
        $val = "";
        if (preg_match_all('/<([^>]*)>/i', $src, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE)) {
            foreach ($matches as $match) {
                $pos2 = $match[0][1];
                if ($pos2 > $pos1) {
                    $src1 = substr($src, $pos1, $pos2 - $pos1);
                    $val .= $this->highlight($kwlist, $src1);
                }
                $val .= $match[0][0];
                $pos1 = $pos2 + strlen($match[0][0]);
            }
        }
        $pos2 = strlen($src);
        if ($pos2 > $pos1) {
            $src1 = substr($src, $pos1, $pos2 - $pos1);
            $val .= $this->highlight($kwlist, $src1);
        }
        return $val;
    }

    // Highlight keyword
    protected function highlight($kwlist, $src)
    {
        $pattern = '';
        foreach ($kwlist as $kw) {
            $pattern .= ($pattern == '' ? '' : '|') . preg_quote($kw, '/');
        }
        if ($pattern == '') {
            return $src;
        }
        $pattern = '/(' . $pattern . ')/' . (SameText(Config("PROJECT_CHARSET"), 'utf-8') ? 'u' : '') . (Config("HIGHLIGHT_COMPARE") ? 'i' : '');
        $src = preg_replace_callback(
            $pattern,
            function ($match) {
                return '<span class="' . $this->highlightName() . ' ew-highlight-search">' . $match[0] . '</span>';
            },
            $src
        );
        return $src;
    }

    // Search WHERE clause
    public function getSearchWhere()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_SEARCH_WHERE"));
    }

    public function setSearchWhere($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_SEARCH_WHERE")] = $v;
    }

    // Session WHERE clause
    public function getSessionWhere()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_WHERE"));
    }

    public function setSessionWhere($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_WHERE")] = $v;
    }

    // Session ORDER BY
    public function getSessionOrderBy()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_ORDER_BY"));
    }

    public function setSessionOrderBy($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_ORDER_BY")] = $v;
    }

    // URL encode
    public function urlEncode($str)
    {
        return urlencode($str);
    }

    // Print
    public function raw($str)
    {
        return $str;
    }
}
