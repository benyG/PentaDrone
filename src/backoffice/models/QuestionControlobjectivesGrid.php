<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class QuestionControlobjectivesGrid extends QuestionControlobjectives
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'question_controlobjectives';

    // Page object name
    public $PageObjName = "QuestionControlobjectivesGrid";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fquestion_controlobjectivesgrid";
    public $FormActionName = "k_action";
    public $FormBlankRowName = "k_blankrow";
    public $FormKeyCountName = "key_count";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $CopyUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $ListUrl;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl()
    {
        $url = ScriptName() . "?";
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return ($this->TableVar == $CurrentForm->getValue("t"));
            }
            if (Get("t") !== null) {
                return ($this->TableVar == Get("t"));
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;

        // Initialize
        $this->FormActionName .= "_" . $this->FormName;
        $this->OldKeyName .= "_" . $this->FormName;
        $this->FormBlankRowName .= "_" . $this->FormName;
        $this->FormKeyCountName .= "_" . $this->FormName;
        $GLOBALS["Grid"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (question_controlobjectives)
        if (!isset($GLOBALS["question_controlobjectives"]) || get_class($GLOBALS["question_controlobjectives"]) == PROJECT_NAMESPACE . "question_controlobjectives") {
            $GLOBALS["question_controlobjectives"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();
        $this->AddUrl = "QuestionControlobjectivesAdd";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'question_controlobjectives');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // List options
        $this->ListOptions = new ListOptions();
        $this->ListOptions->TableVar = $this->TableVar;

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }
        $this->OtherOptions["addedit"] = new ListOptions("div");
        $this->OtherOptions["addedit"]->TagClassName = "ew-add-edit-option";
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $doc = new $class(Container("question_controlobjectives"));
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        unset($GLOBALS["Grid"]);
        if ($url === "") {
            return;
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }
            SaveDebugMessage();
            Redirect(GetUrl($url));
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['controlObj_name'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
    }

    // Lookup data
    public function lookup()
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;

        // Get lookup parameters
        $lookupType = Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal")) {
            $searchValue = Post("sv", "");
            $pageSize = Post("recperpage", 10);
            $offset = Post("start", 0);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = Param("q", "");
            $pageSize = Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
            $start = Param("start", -1);
            $start = is_numeric($start) ? (int)$start : -1;
            $page = Param("page", -1);
            $page = is_numeric($page) ? (int)$page : -1;
            $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        }
        $userSelect = Decrypt(Post("s", ""));
        $userFilter = Decrypt(Post("f", ""));
        $userOrderBy = Decrypt(Post("o", ""));
        $keys = Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        $lookup->toJson($this); // Use settings from current page
    }

    // Class variables
    public $ListOptions; // List options
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $OtherOptions; // Other options
    public $FilterOptions; // Filter options
    public $ImportOptions; // Import options
    public $ListActions; // List actions
    public $SelectedCount = 0;
    public $SelectedIndex = 0;
    public $ShowOtherOptions = false;
    public $DisplayRecords = 20;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $PageSizes = "10,20,50,-1"; // Page sizes (comma separated)
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = ""; // Search WHERE clause
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchRowCount = 0; // For extended search
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $RecordCount = 0; // Record count
    public $EditRowCount;
    public $StartRowCount = 1;
    public $RowCount = 0;
    public $Attrs = []; // Row attributes and cell attributes
    public $RowIndex = 0; // Row index
    public $KeyCount = 0; // Key count
    public $RowAction = ""; // Row action
    public $MultiColumnClass = "col-sm";
    public $MultiColumnEditClass = "w-100";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $MasterRecordExists;
    public $MultiSelectKey;
    public $Command;
    public $RestoreSearch = false;
    public $HashValue; // Hash value
    public $DetailPages;
    public $OldRecordset;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();
        $this->num_ordre->setVisibility();
        $this->controlObj_name->setVisibility();
        $this->question_domain_id->setVisibility();
        $this->layer_id->setVisibility();
        $this->function_csf->setVisibility();
        $this->created_at->setVisibility();
        $this->updated_at->setVisibility();
        $this->hideFieldsForAddEdit();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up master detail parameters
        $this->setupMasterParms();

        // Setup other options
        $this->setupOtherOptions();

        // Set up lookup cache
        $this->setupLookupOptions($this->question_domain_id);
        $this->setupLookupOptions($this->layer_id);
        $this->setupLookupOptions($this->function_csf);

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $filter = "";

        // Get command
        $this->Command = strtolower(Get("cmd"));
        if ($this->isPageRequest()) {
            // Set up records per page
            $this->setupDisplayRecords();

            // Handle reset command
            $this->resetCmd();

            // Hide list options
            if ($this->isExport()) {
                $this->ListOptions->hideAllOptions(["sequence"]);
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            } elseif ($this->isGridAdd() || $this->isGridEdit()) {
                $this->ListOptions->hideAllOptions();
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            }

            // Show grid delete link for grid add / grid edit
            if ($this->AllowAddDeleteRow) {
                if ($this->isGridAdd() || $this->isGridEdit()) {
                    $item = $this->ListOptions["griddelete"];
                    if ($item) {
                        $item->Visible = true;
                    }
                }
            }

            // Set up sorting order
            $this->setupSortOrder();
        }

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 20; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Load Sorting Order
        if ($this->Command != "json") {
            $this->loadSortOrder();
        }

        // Build filter
        $filter = "";

        // Restore master/detail filter
        $this->DbMasterFilter = $this->getMasterFilter(); // Restore master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Restore detail filter
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Load master record
        if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "question_domains") {
            $masterTbl = Container("question_domains");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetch(\PDO::FETCH_ASSOC);
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("QuestionDomainsList"); // Return to master page
                return;
            } else {
                $masterTbl->loadListRowValues($rsmaster);
                $masterTbl->RowType = ROWTYPE_MASTER; // Master row
                $masterTbl->renderListRow();
            }
        }

        // Load master record
        if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "layers") {
            $masterTbl = Container("layers");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetch(\PDO::FETCH_ASSOC);
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("LayersList"); // Return to master page
                return;
            } else {
                $masterTbl->loadListRowValues($rsmaster);
                $masterTbl->RowType = ROWTYPE_MASTER; // Master row
                $masterTbl->renderListRow();
            }
        }

        // Load master record
        if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "functions") {
            $masterTbl = Container("functions");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetch(\PDO::FETCH_ASSOC);
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("FunctionsList"); // Return to master page
                return;
            } else {
                $masterTbl->loadListRowValues($rsmaster);
                $masterTbl->RowType = ROWTYPE_MASTER; // Master row
                $masterTbl->renderListRow();
            }
        }

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $filter;
        } else {
            $this->setSessionWhere($filter);
            $this->CurrentFilter = "";
        }
        if ($this->isGridAdd()) {
            if ($this->CurrentMode == "copy") {
                $this->TotalRecords = $this->listRecordCount();
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->TotalRecords;
                $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
            } else {
                $this->CurrentFilter = "0=1";
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->GridAddRowCount;
            }
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->TotalRecords; // Display all records
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
        }

        // Normal return
        if (IsApi()) {
            $rows = $this->getRecordsFromRecordset($this->Recordset);
            $this->Recordset->close();
            WriteJson(["success" => true, $this->TableVar => $rows, "totalRecordCount" => $this->TotalRecords]);
            $this->terminate(true);
            return;
        }

        // Set up pager
        $this->Pager = new PrevNextPager($this->StartRecord, $this->getRecordsPerPage(), $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Pass table and field properties to client side
            $this->toClientVar(["tableCaption"], ["caption", "Visible", "Required", "IsInvalid", "Raw"]);

            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Rendering event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }
        }
    }

    // Set up number of records displayed per page
    protected function setupDisplayRecords()
    {
        $wrk = Get(Config("TABLE_REC_PER_PAGE"), "");
        if ($wrk != "") {
            if (is_numeric($wrk)) {
                $this->DisplayRecords = (int)$wrk;
            } else {
                if (SameText($wrk, "all")) { // Display all records
                    $this->DisplayRecords = -1;
                } else {
                    $this->DisplayRecords = 20; // Non-numeric, load default
                }
            }
            $this->setRecordsPerPage($this->DisplayRecords); // Save to Session
            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Exit inline mode
    protected function clearInlineMode()
    {
        $this->LastAction = $this->CurrentAction; // Save last action
        $this->CurrentAction = ""; // Clear action
        $_SESSION[SESSION_INLINE_MODE] = ""; // Clear inline mode
    }

    // Switch to Grid Add mode
    protected function gridAddMode()
    {
        $this->CurrentAction = "gridadd";
        $_SESSION[SESSION_INLINE_MODE] = "gridadd";
        $this->hideFieldsForAddEdit();
    }

    // Switch to Grid Edit mode
    protected function gridEditMode()
    {
        $this->CurrentAction = "gridedit";
        $_SESSION[SESSION_INLINE_MODE] = "gridedit";
        $this->hideFieldsForAddEdit();
    }

    // Perform update to grid
    public function gridUpdate()
    {
        global $Language, $CurrentForm;
        $gridUpdate = true;

        // Get old recordset
        $this->CurrentFilter = $this->buildKeyFilter();
        if ($this->CurrentFilter == "") {
            $this->CurrentFilter = "0=1";
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        if ($rs = $conn->executeQuery($sql)) {
            $rsold = $rs->fetchAll();
            $rs->closeCursor();
        }

        // Call Grid Updating event
        if (!$this->gridUpdating($rsold)) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridEditCancelled")); // Set grid edit cancelled message
            }
            return false;
        }
        $key = "";

        // Update row index and get row key
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Update all rows based on key
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            $CurrentForm->Index = $rowindex;
            $this->setKey($CurrentForm->getValue($this->OldKeyName));
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));

            // Load all values and keys
            if ($rowaction != "insertdelete") { // Skip insert then deleted rows
                $this->loadFormValues(); // Get form values
                if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
                    $gridUpdate = $this->OldKey != ""; // Key must not be empty
                } else {
                    $gridUpdate = true;
                }

                // Skip empty row
                if ($rowaction == "insert" && $this->emptyRow()) {
                // Validate form and insert/update/delete record
                } elseif ($gridUpdate) {
                    if ($rowaction == "delete") {
                        $this->CurrentFilter = $this->getRecordFilter();
                        $gridUpdate = $this->deleteRows(); // Delete this row
                    //} elseif (!$this->validateForm()) { // Already done in validateGridForm
                    //    $gridUpdate = false; // Form error, reset action
                    } else {
                        if ($rowaction == "insert") {
                            $gridUpdate = $this->addRow(); // Insert this row
                        } else {
                            if ($this->OldKey != "") {
                                $this->SendEmail = false; // Do not send email on update success
                                $gridUpdate = $this->editRow(); // Update this row
                            }
                        } // End update
                    }
                }
                if ($gridUpdate) {
                    if ($key != "") {
                        $key .= ", ";
                    }
                    $key .= $this->OldKey;
                } else {
                    break;
                }
            }
        }
        if ($gridUpdate) {
            // Get new records
            $rsnew = $conn->fetchAll($sql);

            // Call Grid_Updated event
            $this->gridUpdated($rsold, $rsnew);
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("UpdateFailed")); // Set update failed message
            }
        }
        return $gridUpdate;
    }

    // Build filter for all keys
    protected function buildKeyFilter()
    {
        global $CurrentForm;
        $wrkFilter = "";

        // Update row index and get row key
        $rowindex = 1;
        $CurrentForm->Index = $rowindex;
        $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        while ($thisKey != "") {
            $this->setKey($thisKey);
            if ($this->OldKey != "") {
                $filter = $this->getRecordFilter();
                if ($wrkFilter != "") {
                    $wrkFilter .= " OR ";
                }
                $wrkFilter .= $filter;
            } else {
                $wrkFilter = "0=1";
                break;
            }

            // Update row index and get row key
            $rowindex++; // Next row
            $CurrentForm->Index = $rowindex;
            $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        }
        return $wrkFilter;
    }

    // Perform Grid Add
    public function gridInsert()
    {
        global $Language, $CurrentForm;
        $rowindex = 1;
        $gridInsert = false;
        $conn = $this->getConnection();

        // Call Grid Inserting event
        if (!$this->gridInserting()) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridAddCancelled")); // Set grid add cancelled message
            }
            return false;
        }

        // Init key filter
        $wrkfilter = "";
        $addcnt = 0;
        $key = "";

        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Insert all rows
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "" && $rowaction != "insert") {
                continue; // Skip
            }
            if ($rowaction == "insert") {
                $this->OldKey = strval($CurrentForm->getValue($this->OldKeyName));
                $this->loadOldRecord(); // Load old record
            }
            $this->loadFormValues(); // Get form values
            if (!$this->emptyRow()) {
                $addcnt++;
                $this->SendEmail = false; // Do not send email on insert success

                // Validate form // Already done in validateGridForm
                //if (!$this->validateForm()) {
                //    $gridInsert = false; // Form error, reset action
                //} else {
                    $gridInsert = $this->addRow($this->OldRecordset); // Insert this row
                //}
                if ($gridInsert) {
                    if ($key != "") {
                        $key .= Config("COMPOSITE_KEY_SEPARATOR");
                    }
                    $key .= $this->controlObj_name->CurrentValue;

                    // Add filter for this record
                    $filter = $this->getRecordFilter();
                    if ($wrkfilter != "") {
                        $wrkfilter .= " OR ";
                    }
                    $wrkfilter .= $filter;
                } else {
                    break;
                }
            }
        }
        if ($addcnt == 0) { // No record inserted
            $this->clearInlineMode(); // Clear grid add mode and return
            return true;
        }
        if ($gridInsert) {
            // Get new records
            $this->CurrentFilter = $wrkfilter;
            $sql = $this->getCurrentSql();
            $rsnew = $conn->fetchAll($sql);

            // Call Grid_Inserted event
            $this->gridInserted($rsnew);
            $this->clearInlineMode(); // Clear grid add mode
        } else {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("InsertFailed")); // Set insert failed message
            }
        }
        return $gridInsert;
    }

    // Check if empty row
    public function emptyRow()
    {
        global $CurrentForm;
        if ($CurrentForm->hasValue("x_num_ordre") && $CurrentForm->hasValue("o_num_ordre") && $this->num_ordre->CurrentValue != $this->num_ordre->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_controlObj_name") && $CurrentForm->hasValue("o_controlObj_name") && $this->controlObj_name->CurrentValue != $this->controlObj_name->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_question_domain_id") && $CurrentForm->hasValue("o_question_domain_id") && $this->question_domain_id->CurrentValue != $this->question_domain_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_layer_id") && $CurrentForm->hasValue("o_layer_id") && $this->layer_id->CurrentValue != $this->layer_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_function_csf") && $CurrentForm->hasValue("o_function_csf") && $this->function_csf->CurrentValue != $this->function_csf->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_created_at") && $CurrentForm->hasValue("o_created_at") && $this->created_at->CurrentValue != $this->created_at->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_updated_at") && $CurrentForm->hasValue("o_updated_at") && $this->updated_at->CurrentValue != $this->updated_at->OldValue) {
            return false;
        }
        return true;
    }

    // Validate grid form
    public function validateGridForm()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Validate all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } elseif (!$this->validateForm()) {
                    return false;
                }
            }
        }
        return true;
    }

    // Get all form values of the grid
    public function getGridFormValues()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }
        $rows = [];

        // Loop through all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } else {
                    $rows[] = $this->getFieldValues("FormValue"); // Return row as array
                }
            }
        }
        return $rows; // Return as array of array
    }

    // Restore form values for current row
    public function restoreCurrentRowFormValues($idx)
    {
        global $CurrentForm;

        // Get row based on current index
        $CurrentForm->Index = $idx;
        $rowaction = strval($CurrentForm->getValue($this->FormActionName));
        $this->loadFormValues(); // Load form values
        // Set up invalid status correctly
        $this->resetFormError();
        if ($rowaction == "insert" && $this->emptyRow()) {
            // Ignore
        } else {
            $this->validateForm();
        }
    }

    // Reset form status
    public function resetFormError()
    {
        $this->num_ordre->clearErrorMessage();
        $this->controlObj_name->clearErrorMessage();
        $this->question_domain_id->clearErrorMessage();
        $this->layer_id->clearErrorMessage();
        $this->function_csf->clearErrorMessage();
        $this->created_at->clearErrorMessage();
        $this->updated_at->clearErrorMessage();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load sort order parameters
    protected function loadSortOrder()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        if ($orderBy == "") {
            $this->DefaultSort = "";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($useDefaultSort) {
                    $orderBy = $this->getSqlOrderBy();
                    $this->setSessionOrderBy($orderBy);
                } else {
                    $this->setSessionOrderBy("");
                }
            }
        }
    }

    // Reset command
    // - cmd=reset (Reset search parameters)
    // - cmd=resetall (Reset search and master/detail parameters)
    // - cmd=resetsort (Reset sort parameters)
    protected function resetCmd()
    {
        // Check if reset command
        if (StartsString("reset", $this->Command)) {
            // Reset master/detail keys
            if ($this->Command == "resetall") {
                $this->setCurrentMasterTable(""); // Clear master table
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
                        $this->question_domain_id->setSessionValue("");
                        $this->layer_id->setSessionValue("");
                        $this->function_csf->setSessionValue("");
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
            }

            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Set up list options
    protected function setupListOptions()
    {
        global $Security, $Language;

        // "griddelete"
        if ($this->AllowAddDeleteRow) {
            $item = &$this->ListOptions->add("griddelete");
            $item->CssClass = "text-nowrap";
            $item->OnLeft = false;
            $item->Visible = false; // Default hidden
        }

        // Add group option item
        $item = &$this->ListOptions->add($this->ListOptions->GroupOptionName);
        $item->Body = "";
        $item->OnLeft = false;
        $item->Visible = false;

        // "view"
        $item = &$this->ListOptions->add("view");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canView();
        $item->OnLeft = false;

        // "edit"
        $item = &$this->ListOptions->add("edit");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canEdit();
        $item->OnLeft = false;

        // "copy"
        $item = &$this->ListOptions->add("copy");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canAdd();
        $item->OnLeft = false;

        // "delete"
        $item = &$this->ListOptions->add("delete");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canDelete();
        $item->OnLeft = false;

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = false;
        $this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
        $this->ListOptions->UseButtonGroup = false;
        if ($this->ListOptions->UseButtonGroup && IsMobile()) {
            $this->ListOptions->UseDropDownButton = true;
        }

        //$this->ListOptions->ButtonClass = ""; // Class for button group

        // Call ListOptions_Load event
        $this->listOptionsLoad();
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        $item->Visible = $this->ListOptions->groupOptionVisible();
    }

    // Render list options
    public function renderListOptions()
    {
        global $Security, $Language, $CurrentForm;
        $this->ListOptions->loadDefault();

        // Call ListOptions_Rendering event
        $this->listOptionsRendering();

        // Set up row action and key
        if ($CurrentForm && is_numeric($this->RowIndex) && $this->RowType != "view") {
            $CurrentForm->Index = $this->RowIndex;
            $actionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
            $oldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->OldKeyName);
            $blankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
            if ($this->RowAction != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $actionName . "\" id=\"" . $actionName . "\" value=\"" . $this->RowAction . "\">";
            }
            $oldKey = $this->getKey(false); // Get from OldValue
            if ($oldKeyName != "" && $oldKey != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $oldKeyName . "\" id=\"" . $oldKeyName . "\" value=\"" . HtmlEncode($oldKey) . "\">";
            }
            if ($this->RowAction == "insert" && $this->isConfirm() && $this->emptyRow()) {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $blankRowName . "\" id=\"" . $blankRowName . "\" value=\"1\">";
            }
        }

        // "delete"
        if ($this->AllowAddDeleteRow) {
            if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
                $options = &$this->ListOptions;
                $options->UseButtonGroup = true; // Use button group for grid delete button
                $opt = $options["griddelete"];
                $opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" onclick=\"return ew.deleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->phrase("DeleteLink") . "</a>";
            }
        }
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView()) {
                $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\">" . $Language->phrase("ViewLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit()) {
                $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "copy"
            $opt = $this->ListOptions["copy"];
            $copycaption = HtmlTitle($Language->phrase("CopyLink"));
            if ($Security->canAdd()) {
                $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\">" . $Language->phrase("CopyLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "delete"
            $opt = $this->ListOptions["delete"];
            if ($Security->canDelete()) {
            $opt->Body = "<a class=\"ew-row-link ew-delete\"" . "" . " title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $Language->phrase("DeleteLink") . "</a>";
            } else {
                $opt->Body = "";
            }
        } // End View mode
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $option = $this->OtherOptions["addedit"];
        $option->UseDropDownButton = false;
        $option->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
        $option->UseButtonGroup = true;
        //$option->ButtonClass = ""; // Class for button group
        $item = &$option->add($option->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;

        // Add
        if ($this->CurrentMode == "view") { // Check view mode
            $item = &$option->add("add");
            $addcaption = HtmlTitle($Language->phrase("AddLink"));
            $this->AddUrl = $this->getAddUrl();
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
            $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        }
    }

    // Render other options
    public function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        if (($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") && !$this->isConfirm()) { // Check add/copy/edit mode
            if ($this->AllowAddDeleteRow) {
                $option = $options["addedit"];
                $option->UseDropDownButton = false;
                $item = &$option->add("addblankrow");
                $item->Body = "<a class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" href=\"#\" onclick=\"return ew.addGridRow(this);\">" . $Language->phrase("AddBlankRow") . "</a>";
                $item->Visible = $Security->canAdd();
                $this->ShowOtherOptions = $item->Visible;
            }
        }
        if ($this->CurrentMode == "view") { // Check view mode
            $option = $options["addedit"];
            $item = $option["add"];
            $this->ShowOtherOptions = $item && $item->Visible;
        }
    }

    // Set up list options (extended codes)
    protected function setupListOptionsExt()
    {
    }

    // Render list options (extended codes)
    protected function renderListOptionsExt()
    {
    }

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->num_ordre->CurrentValue = null;
        $this->num_ordre->OldValue = $this->num_ordre->CurrentValue;
        $this->controlObj_name->CurrentValue = null;
        $this->controlObj_name->OldValue = $this->controlObj_name->CurrentValue;
        $this->question_domain_id->CurrentValue = null;
        $this->question_domain_id->OldValue = $this->question_domain_id->CurrentValue;
        $this->layer_id->CurrentValue = null;
        $this->layer_id->OldValue = $this->layer_id->CurrentValue;
        $this->function_csf->CurrentValue = null;
        $this->function_csf->OldValue = $this->function_csf->CurrentValue;
        $this->created_at->CurrentValue = null;
        $this->created_at->OldValue = $this->created_at->CurrentValue;
        $this->updated_at->CurrentValue = null;
        $this->updated_at->OldValue = $this->updated_at->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $CurrentForm->FormName = $this->FormName;

        // Check field name 'num_ordre' first before field var 'x_num_ordre'
        $val = $CurrentForm->hasValue("num_ordre") ? $CurrentForm->getValue("num_ordre") : $CurrentForm->getValue("x_num_ordre");
        if (!$this->num_ordre->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->num_ordre->Visible = false; // Disable update for API request
            } else {
                $this->num_ordre->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_num_ordre")) {
            $this->num_ordre->setOldValue($CurrentForm->getValue("o_num_ordre"));
        }

        // Check field name 'controlObj_name' first before field var 'x_controlObj_name'
        $val = $CurrentForm->hasValue("controlObj_name") ? $CurrentForm->getValue("controlObj_name") : $CurrentForm->getValue("x_controlObj_name");
        if (!$this->controlObj_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->controlObj_name->Visible = false; // Disable update for API request
            } else {
                $this->controlObj_name->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_controlObj_name")) {
            $this->controlObj_name->setOldValue($CurrentForm->getValue("o_controlObj_name"));
        }

        // Check field name 'question_domain_id' first before field var 'x_question_domain_id'
        $val = $CurrentForm->hasValue("question_domain_id") ? $CurrentForm->getValue("question_domain_id") : $CurrentForm->getValue("x_question_domain_id");
        if (!$this->question_domain_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->question_domain_id->Visible = false; // Disable update for API request
            } else {
                $this->question_domain_id->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_question_domain_id")) {
            $this->question_domain_id->setOldValue($CurrentForm->getValue("o_question_domain_id"));
        }

        // Check field name 'layer_id' first before field var 'x_layer_id'
        $val = $CurrentForm->hasValue("layer_id") ? $CurrentForm->getValue("layer_id") : $CurrentForm->getValue("x_layer_id");
        if (!$this->layer_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->layer_id->Visible = false; // Disable update for API request
            } else {
                $this->layer_id->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_layer_id")) {
            $this->layer_id->setOldValue($CurrentForm->getValue("o_layer_id"));
        }

        // Check field name 'function_csf' first before field var 'x_function_csf'
        $val = $CurrentForm->hasValue("function_csf") ? $CurrentForm->getValue("function_csf") : $CurrentForm->getValue("x_function_csf");
        if (!$this->function_csf->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->function_csf->Visible = false; // Disable update for API request
            } else {
                $this->function_csf->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_function_csf")) {
            $this->function_csf->setOldValue($CurrentForm->getValue("o_function_csf"));
        }

        // Check field name 'created_at' first before field var 'x_created_at'
        $val = $CurrentForm->hasValue("created_at") ? $CurrentForm->getValue("created_at") : $CurrentForm->getValue("x_created_at");
        if (!$this->created_at->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->created_at->Visible = false; // Disable update for API request
            } else {
                $this->created_at->setFormValue($val);
            }
            $this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, 0);
        }
        if ($CurrentForm->hasValue("o_created_at")) {
            $this->created_at->setOldValue($CurrentForm->getValue("o_created_at"));
        }

        // Check field name 'updated_at' first before field var 'x_updated_at'
        $val = $CurrentForm->hasValue("updated_at") ? $CurrentForm->getValue("updated_at") : $CurrentForm->getValue("x_updated_at");
        if (!$this->updated_at->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->updated_at->Visible = false; // Disable update for API request
            } else {
                $this->updated_at->setFormValue($val);
            }
            $this->updated_at->CurrentValue = UnFormatDateTime($this->updated_at->CurrentValue, 0);
        }
        if ($CurrentForm->hasValue("o_updated_at")) {
            $this->updated_at->setOldValue($CurrentForm->getValue("o_updated_at"));
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->num_ordre->CurrentValue = $this->num_ordre->FormValue;
        $this->controlObj_name->CurrentValue = $this->controlObj_name->FormValue;
        $this->question_domain_id->CurrentValue = $this->question_domain_id->FormValue;
        $this->layer_id->CurrentValue = $this->layer_id->FormValue;
        $this->function_csf->CurrentValue = $this->function_csf->FormValue;
        $this->created_at->CurrentValue = $this->created_at->FormValue;
        $this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, 0);
        $this->updated_at->CurrentValue = $this->updated_at->FormValue;
        $this->updated_at->CurrentValue = UnFormatDateTime($this->updated_at->CurrentValue, 0);
    }

    // Load recordset
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $stmt = $sql->execute();
        $rs = new Recordset($stmt, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($rs);
        return $rs;
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssoc($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }

        // Call Row Selected event
        $this->rowSelected($row);
        if (!$rs) {
            return;
        }
        $this->num_ordre->setDbValue($row['num_ordre']);
        $this->controlObj_name->setDbValue($row['controlObj_name']);
        $this->question_domain_id->setDbValue($row['question_domain_id']);
        $this->layer_id->setDbValue($row['layer_id']);
        $this->function_csf->setDbValue($row['function_csf']);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['num_ordre'] = $this->num_ordre->CurrentValue;
        $row['controlObj_name'] = $this->controlObj_name->CurrentValue;
        $row['question_domain_id'] = $this->question_domain_id->CurrentValue;
        $row['layer_id'] = $this->layer_id->CurrentValue;
        $row['function_csf'] = $this->function_csf->CurrentValue;
        $row['created_at'] = $this->created_at->CurrentValue;
        $row['updated_at'] = $this->updated_at->CurrentValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        $this->OldRecordset = null;
        $validKey = $this->OldKey != "";
        if ($validKey) {
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $this->OldRecordset = LoadRecordset($sql, $conn);
        }
        $this->loadRowValues($this->OldRecordset); // Load row values
        return $validKey;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs
        $this->ViewUrl = $this->getViewUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // num_ordre

        // controlObj_name

        // question_domain_id

        // layer_id

        // function_csf

        // created_at

        // updated_at
        if ($this->RowType == ROWTYPE_VIEW) {
            // num_ordre
            $this->num_ordre->ViewValue = $this->num_ordre->CurrentValue;
            $this->num_ordre->ViewValue = FormatNumber($this->num_ordre->ViewValue, 0, -2, -2, -2);
            $this->num_ordre->ViewCustomAttributes = "";

            // controlObj_name
            $this->controlObj_name->ViewValue = $this->controlObj_name->CurrentValue;
            $this->controlObj_name->ViewCustomAttributes = "";

            // question_domain_id
            $curVal = strval($this->question_domain_id->CurrentValue);
            if ($curVal != "") {
                $this->question_domain_id->ViewValue = $this->question_domain_id->lookupCacheOption($curVal);
                if ($this->question_domain_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "`domain_name`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->question_domain_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->question_domain_id->Lookup->renderViewRow($rswrk[0]);
                        $this->question_domain_id->ViewValue = $this->question_domain_id->displayValue($arwrk);
                    } else {
                        $this->question_domain_id->ViewValue = $this->question_domain_id->CurrentValue;
                    }
                }
            } else {
                $this->question_domain_id->ViewValue = null;
            }
            $this->question_domain_id->ViewCustomAttributes = "";

            // layer_id
            $curVal = strval($this->layer_id->CurrentValue);
            if ($curVal != "") {
                $this->layer_id->ViewValue = $this->layer_id->lookupCacheOption($curVal);
                if ($this->layer_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "`name`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->layer_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->layer_id->Lookup->renderViewRow($rswrk[0]);
                        $this->layer_id->ViewValue = $this->layer_id->displayValue($arwrk);
                    } else {
                        $this->layer_id->ViewValue = $this->layer_id->CurrentValue;
                    }
                }
            } else {
                $this->layer_id->ViewValue = null;
            }
            $this->layer_id->ViewCustomAttributes = "";

            // function_csf
            $this->function_csf->ViewValue = $this->function_csf->CurrentValue;
            $curVal = strval($this->function_csf->CurrentValue);
            if ($curVal != "") {
                $this->function_csf->ViewValue = $this->function_csf->lookupCacheOption($curVal);
                if ($this->function_csf->ViewValue === null) { // Lookup from database
                    $filterWrk = "`name`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->function_csf->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->function_csf->Lookup->renderViewRow($rswrk[0]);
                        $this->function_csf->ViewValue = $this->function_csf->displayValue($arwrk);
                    } else {
                        $this->function_csf->ViewValue = $this->function_csf->CurrentValue;
                    }
                }
            } else {
                $this->function_csf->ViewValue = null;
            }
            $this->function_csf->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
            $this->updated_at->ViewCustomAttributes = "";

            // num_ordre
            $this->num_ordre->LinkCustomAttributes = "";
            $this->num_ordre->HrefValue = "";
            $this->num_ordre->TooltipValue = "";

            // controlObj_name
            $this->controlObj_name->LinkCustomAttributes = "";
            $this->controlObj_name->HrefValue = "";
            $this->controlObj_name->TooltipValue = "";

            // question_domain_id
            $this->question_domain_id->LinkCustomAttributes = "";
            $this->question_domain_id->HrefValue = "";
            $this->question_domain_id->TooltipValue = "";

            // layer_id
            $this->layer_id->LinkCustomAttributes = "";
            $this->layer_id->HrefValue = "";
            $this->layer_id->TooltipValue = "";

            // function_csf
            $this->function_csf->LinkCustomAttributes = "";
            $this->function_csf->HrefValue = "";
            $this->function_csf->TooltipValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";
            $this->created_at->TooltipValue = "";

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";
            $this->updated_at->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // num_ordre
            $this->num_ordre->EditAttrs["class"] = "form-control";
            $this->num_ordre->EditCustomAttributes = "";
            $this->num_ordre->EditValue = HtmlEncode($this->num_ordre->CurrentValue);
            $this->num_ordre->PlaceHolder = RemoveHtml($this->num_ordre->caption());

            // controlObj_name
            $this->controlObj_name->EditAttrs["class"] = "form-control";
            $this->controlObj_name->EditCustomAttributes = "";
            if (!$this->controlObj_name->Raw) {
                $this->controlObj_name->CurrentValue = HtmlDecode($this->controlObj_name->CurrentValue);
            }
            $this->controlObj_name->EditValue = HtmlEncode($this->controlObj_name->CurrentValue);
            $this->controlObj_name->PlaceHolder = RemoveHtml($this->controlObj_name->caption());

            // question_domain_id
            $this->question_domain_id->EditAttrs["class"] = "form-control";
            $this->question_domain_id->EditCustomAttributes = "";
            if ($this->question_domain_id->getSessionValue() != "") {
                $this->question_domain_id->CurrentValue = GetForeignKeyValue($this->question_domain_id->getSessionValue());
                $this->question_domain_id->OldValue = $this->question_domain_id->CurrentValue;
                $curVal = strval($this->question_domain_id->CurrentValue);
                if ($curVal != "") {
                    $this->question_domain_id->ViewValue = $this->question_domain_id->lookupCacheOption($curVal);
                    if ($this->question_domain_id->ViewValue === null) { // Lookup from database
                        $filterWrk = "`domain_name`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                        $sqlWrk = $this->question_domain_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->question_domain_id->Lookup->renderViewRow($rswrk[0]);
                            $this->question_domain_id->ViewValue = $this->question_domain_id->displayValue($arwrk);
                        } else {
                            $this->question_domain_id->ViewValue = $this->question_domain_id->CurrentValue;
                        }
                    }
                } else {
                    $this->question_domain_id->ViewValue = null;
                }
                $this->question_domain_id->ViewCustomAttributes = "";
            } else {
                $curVal = trim(strval($this->question_domain_id->CurrentValue));
                if ($curVal != "") {
                    $this->question_domain_id->ViewValue = $this->question_domain_id->lookupCacheOption($curVal);
                } else {
                    $this->question_domain_id->ViewValue = $this->question_domain_id->Lookup !== null && is_array($this->question_domain_id->Lookup->Options) ? $curVal : null;
                }
                if ($this->question_domain_id->ViewValue !== null) { // Load from cache
                    $this->question_domain_id->EditValue = array_values($this->question_domain_id->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`domain_name`" . SearchString("=", $this->question_domain_id->CurrentValue, DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->question_domain_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->question_domain_id->EditValue = $arwrk;
                }
                $this->question_domain_id->PlaceHolder = RemoveHtml($this->question_domain_id->caption());
            }

            // layer_id
            $this->layer_id->EditAttrs["class"] = "form-control";
            $this->layer_id->EditCustomAttributes = "";
            if ($this->layer_id->getSessionValue() != "") {
                $this->layer_id->CurrentValue = GetForeignKeyValue($this->layer_id->getSessionValue());
                $this->layer_id->OldValue = $this->layer_id->CurrentValue;
                $curVal = strval($this->layer_id->CurrentValue);
                if ($curVal != "") {
                    $this->layer_id->ViewValue = $this->layer_id->lookupCacheOption($curVal);
                    if ($this->layer_id->ViewValue === null) { // Lookup from database
                        $filterWrk = "`name`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                        $sqlWrk = $this->layer_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->layer_id->Lookup->renderViewRow($rswrk[0]);
                            $this->layer_id->ViewValue = $this->layer_id->displayValue($arwrk);
                        } else {
                            $this->layer_id->ViewValue = $this->layer_id->CurrentValue;
                        }
                    }
                } else {
                    $this->layer_id->ViewValue = null;
                }
                $this->layer_id->ViewCustomAttributes = "";
            } else {
                $curVal = trim(strval($this->layer_id->CurrentValue));
                if ($curVal != "") {
                    $this->layer_id->ViewValue = $this->layer_id->lookupCacheOption($curVal);
                } else {
                    $this->layer_id->ViewValue = $this->layer_id->Lookup !== null && is_array($this->layer_id->Lookup->Options) ? $curVal : null;
                }
                if ($this->layer_id->ViewValue !== null) { // Load from cache
                    $this->layer_id->EditValue = array_values($this->layer_id->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`name`" . SearchString("=", $this->layer_id->CurrentValue, DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->layer_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->layer_id->EditValue = $arwrk;
                }
                $this->layer_id->PlaceHolder = RemoveHtml($this->layer_id->caption());
            }

            // function_csf
            $this->function_csf->EditAttrs["class"] = "form-control";
            $this->function_csf->EditCustomAttributes = "";
            if ($this->function_csf->getSessionValue() != "") {
                $this->function_csf->CurrentValue = GetForeignKeyValue($this->function_csf->getSessionValue());
                $this->function_csf->OldValue = $this->function_csf->CurrentValue;
                $this->function_csf->ViewValue = $this->function_csf->CurrentValue;
                $curVal = strval($this->function_csf->CurrentValue);
                if ($curVal != "") {
                    $this->function_csf->ViewValue = $this->function_csf->lookupCacheOption($curVal);
                    if ($this->function_csf->ViewValue === null) { // Lookup from database
                        $filterWrk = "`name`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                        $sqlWrk = $this->function_csf->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->function_csf->Lookup->renderViewRow($rswrk[0]);
                            $this->function_csf->ViewValue = $this->function_csf->displayValue($arwrk);
                        } else {
                            $this->function_csf->ViewValue = $this->function_csf->CurrentValue;
                        }
                    }
                } else {
                    $this->function_csf->ViewValue = null;
                }
                $this->function_csf->ViewCustomAttributes = "";
            } else {
                if (!$this->function_csf->Raw) {
                    $this->function_csf->CurrentValue = HtmlDecode($this->function_csf->CurrentValue);
                }
                $this->function_csf->EditValue = HtmlEncode($this->function_csf->CurrentValue);
                $curVal = strval($this->function_csf->CurrentValue);
                if ($curVal != "") {
                    $this->function_csf->EditValue = $this->function_csf->lookupCacheOption($curVal);
                    if ($this->function_csf->EditValue === null) { // Lookup from database
                        $filterWrk = "`name`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                        $sqlWrk = $this->function_csf->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->function_csf->Lookup->renderViewRow($rswrk[0]);
                            $this->function_csf->EditValue = $this->function_csf->displayValue($arwrk);
                        } else {
                            $this->function_csf->EditValue = HtmlEncode($this->function_csf->CurrentValue);
                        }
                    }
                } else {
                    $this->function_csf->EditValue = null;
                }
                $this->function_csf->PlaceHolder = RemoveHtml($this->function_csf->caption());
            }

            // created_at
            $this->created_at->EditAttrs["class"] = "form-control";
            $this->created_at->EditCustomAttributes = "";
            $this->created_at->EditValue = HtmlEncode(FormatDateTime($this->created_at->CurrentValue, 8));
            $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

            // updated_at
            $this->updated_at->EditAttrs["class"] = "form-control";
            $this->updated_at->EditCustomAttributes = "";
            $this->updated_at->EditValue = HtmlEncode(FormatDateTime($this->updated_at->CurrentValue, 8));
            $this->updated_at->PlaceHolder = RemoveHtml($this->updated_at->caption());

            // Add refer script

            // num_ordre
            $this->num_ordre->LinkCustomAttributes = "";
            $this->num_ordre->HrefValue = "";

            // controlObj_name
            $this->controlObj_name->LinkCustomAttributes = "";
            $this->controlObj_name->HrefValue = "";

            // question_domain_id
            $this->question_domain_id->LinkCustomAttributes = "";
            $this->question_domain_id->HrefValue = "";

            // layer_id
            $this->layer_id->LinkCustomAttributes = "";
            $this->layer_id->HrefValue = "";

            // function_csf
            $this->function_csf->LinkCustomAttributes = "";
            $this->function_csf->HrefValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // num_ordre
            $this->num_ordre->EditAttrs["class"] = "form-control";
            $this->num_ordre->EditCustomAttributes = "";
            $this->num_ordre->EditValue = HtmlEncode($this->num_ordre->CurrentValue);
            $this->num_ordre->PlaceHolder = RemoveHtml($this->num_ordre->caption());

            // controlObj_name
            $this->controlObj_name->EditAttrs["class"] = "form-control";
            $this->controlObj_name->EditCustomAttributes = "";
            if (!$this->controlObj_name->Raw) {
                $this->controlObj_name->CurrentValue = HtmlDecode($this->controlObj_name->CurrentValue);
            }
            $this->controlObj_name->EditValue = HtmlEncode($this->controlObj_name->CurrentValue);
            $this->controlObj_name->PlaceHolder = RemoveHtml($this->controlObj_name->caption());

            // question_domain_id
            $this->question_domain_id->EditAttrs["class"] = "form-control";
            $this->question_domain_id->EditCustomAttributes = "";
            if ($this->question_domain_id->getSessionValue() != "") {
                $this->question_domain_id->CurrentValue = GetForeignKeyValue($this->question_domain_id->getSessionValue());
                $this->question_domain_id->OldValue = $this->question_domain_id->CurrentValue;
                $curVal = strval($this->question_domain_id->CurrentValue);
                if ($curVal != "") {
                    $this->question_domain_id->ViewValue = $this->question_domain_id->lookupCacheOption($curVal);
                    if ($this->question_domain_id->ViewValue === null) { // Lookup from database
                        $filterWrk = "`domain_name`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                        $sqlWrk = $this->question_domain_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->question_domain_id->Lookup->renderViewRow($rswrk[0]);
                            $this->question_domain_id->ViewValue = $this->question_domain_id->displayValue($arwrk);
                        } else {
                            $this->question_domain_id->ViewValue = $this->question_domain_id->CurrentValue;
                        }
                    }
                } else {
                    $this->question_domain_id->ViewValue = null;
                }
                $this->question_domain_id->ViewCustomAttributes = "";
            } else {
                $curVal = trim(strval($this->question_domain_id->CurrentValue));
                if ($curVal != "") {
                    $this->question_domain_id->ViewValue = $this->question_domain_id->lookupCacheOption($curVal);
                } else {
                    $this->question_domain_id->ViewValue = $this->question_domain_id->Lookup !== null && is_array($this->question_domain_id->Lookup->Options) ? $curVal : null;
                }
                if ($this->question_domain_id->ViewValue !== null) { // Load from cache
                    $this->question_domain_id->EditValue = array_values($this->question_domain_id->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`domain_name`" . SearchString("=", $this->question_domain_id->CurrentValue, DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->question_domain_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->question_domain_id->EditValue = $arwrk;
                }
                $this->question_domain_id->PlaceHolder = RemoveHtml($this->question_domain_id->caption());
            }

            // layer_id
            $this->layer_id->EditAttrs["class"] = "form-control";
            $this->layer_id->EditCustomAttributes = "";
            if ($this->layer_id->getSessionValue() != "") {
                $this->layer_id->CurrentValue = GetForeignKeyValue($this->layer_id->getSessionValue());
                $this->layer_id->OldValue = $this->layer_id->CurrentValue;
                $curVal = strval($this->layer_id->CurrentValue);
                if ($curVal != "") {
                    $this->layer_id->ViewValue = $this->layer_id->lookupCacheOption($curVal);
                    if ($this->layer_id->ViewValue === null) { // Lookup from database
                        $filterWrk = "`name`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                        $sqlWrk = $this->layer_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->layer_id->Lookup->renderViewRow($rswrk[0]);
                            $this->layer_id->ViewValue = $this->layer_id->displayValue($arwrk);
                        } else {
                            $this->layer_id->ViewValue = $this->layer_id->CurrentValue;
                        }
                    }
                } else {
                    $this->layer_id->ViewValue = null;
                }
                $this->layer_id->ViewCustomAttributes = "";
            } else {
                $curVal = trim(strval($this->layer_id->CurrentValue));
                if ($curVal != "") {
                    $this->layer_id->ViewValue = $this->layer_id->lookupCacheOption($curVal);
                } else {
                    $this->layer_id->ViewValue = $this->layer_id->Lookup !== null && is_array($this->layer_id->Lookup->Options) ? $curVal : null;
                }
                if ($this->layer_id->ViewValue !== null) { // Load from cache
                    $this->layer_id->EditValue = array_values($this->layer_id->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`name`" . SearchString("=", $this->layer_id->CurrentValue, DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->layer_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->layer_id->EditValue = $arwrk;
                }
                $this->layer_id->PlaceHolder = RemoveHtml($this->layer_id->caption());
            }

            // function_csf
            $this->function_csf->EditAttrs["class"] = "form-control";
            $this->function_csf->EditCustomAttributes = "";
            if ($this->function_csf->getSessionValue() != "") {
                $this->function_csf->CurrentValue = GetForeignKeyValue($this->function_csf->getSessionValue());
                $this->function_csf->OldValue = $this->function_csf->CurrentValue;
                $this->function_csf->ViewValue = $this->function_csf->CurrentValue;
                $curVal = strval($this->function_csf->CurrentValue);
                if ($curVal != "") {
                    $this->function_csf->ViewValue = $this->function_csf->lookupCacheOption($curVal);
                    if ($this->function_csf->ViewValue === null) { // Lookup from database
                        $filterWrk = "`name`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                        $sqlWrk = $this->function_csf->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->function_csf->Lookup->renderViewRow($rswrk[0]);
                            $this->function_csf->ViewValue = $this->function_csf->displayValue($arwrk);
                        } else {
                            $this->function_csf->ViewValue = $this->function_csf->CurrentValue;
                        }
                    }
                } else {
                    $this->function_csf->ViewValue = null;
                }
                $this->function_csf->ViewCustomAttributes = "";
            } else {
                if (!$this->function_csf->Raw) {
                    $this->function_csf->CurrentValue = HtmlDecode($this->function_csf->CurrentValue);
                }
                $this->function_csf->EditValue = HtmlEncode($this->function_csf->CurrentValue);
                $curVal = strval($this->function_csf->CurrentValue);
                if ($curVal != "") {
                    $this->function_csf->EditValue = $this->function_csf->lookupCacheOption($curVal);
                    if ($this->function_csf->EditValue === null) { // Lookup from database
                        $filterWrk = "`name`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                        $sqlWrk = $this->function_csf->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->function_csf->Lookup->renderViewRow($rswrk[0]);
                            $this->function_csf->EditValue = $this->function_csf->displayValue($arwrk);
                        } else {
                            $this->function_csf->EditValue = HtmlEncode($this->function_csf->CurrentValue);
                        }
                    }
                } else {
                    $this->function_csf->EditValue = null;
                }
                $this->function_csf->PlaceHolder = RemoveHtml($this->function_csf->caption());
            }

            // created_at
            $this->created_at->EditAttrs["class"] = "form-control";
            $this->created_at->EditCustomAttributes = "";
            $this->created_at->EditValue = HtmlEncode(FormatDateTime($this->created_at->CurrentValue, 8));
            $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

            // updated_at
            $this->updated_at->EditAttrs["class"] = "form-control";
            $this->updated_at->EditCustomAttributes = "";
            $this->updated_at->EditValue = HtmlEncode(FormatDateTime($this->updated_at->CurrentValue, 8));
            $this->updated_at->PlaceHolder = RemoveHtml($this->updated_at->caption());

            // Edit refer script

            // num_ordre
            $this->num_ordre->LinkCustomAttributes = "";
            $this->num_ordre->HrefValue = "";

            // controlObj_name
            $this->controlObj_name->LinkCustomAttributes = "";
            $this->controlObj_name->HrefValue = "";

            // question_domain_id
            $this->question_domain_id->LinkCustomAttributes = "";
            $this->question_domain_id->HrefValue = "";

            // layer_id
            $this->layer_id->LinkCustomAttributes = "";
            $this->layer_id->HrefValue = "";

            // function_csf
            $this->function_csf->LinkCustomAttributes = "";
            $this->function_csf->HrefValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if ($this->num_ordre->Required) {
            if (!$this->num_ordre->IsDetailKey && EmptyValue($this->num_ordre->FormValue)) {
                $this->num_ordre->addErrorMessage(str_replace("%s", $this->num_ordre->caption(), $this->num_ordre->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->num_ordre->FormValue)) {
            $this->num_ordre->addErrorMessage($this->num_ordre->getErrorMessage(false));
        }
        if ($this->controlObj_name->Required) {
            if (!$this->controlObj_name->IsDetailKey && EmptyValue($this->controlObj_name->FormValue)) {
                $this->controlObj_name->addErrorMessage(str_replace("%s", $this->controlObj_name->caption(), $this->controlObj_name->RequiredErrorMessage));
            }
        }
        if ($this->question_domain_id->Required) {
            if (!$this->question_domain_id->IsDetailKey && EmptyValue($this->question_domain_id->FormValue)) {
                $this->question_domain_id->addErrorMessage(str_replace("%s", $this->question_domain_id->caption(), $this->question_domain_id->RequiredErrorMessage));
            }
        }
        if ($this->layer_id->Required) {
            if (!$this->layer_id->IsDetailKey && EmptyValue($this->layer_id->FormValue)) {
                $this->layer_id->addErrorMessage(str_replace("%s", $this->layer_id->caption(), $this->layer_id->RequiredErrorMessage));
            }
        }
        if ($this->function_csf->Required) {
            if (!$this->function_csf->IsDetailKey && EmptyValue($this->function_csf->FormValue)) {
                $this->function_csf->addErrorMessage(str_replace("%s", $this->function_csf->caption(), $this->function_csf->RequiredErrorMessage));
            }
        }
        if ($this->created_at->Required) {
            if (!$this->created_at->IsDetailKey && EmptyValue($this->created_at->FormValue)) {
                $this->created_at->addErrorMessage(str_replace("%s", $this->created_at->caption(), $this->created_at->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->created_at->FormValue)) {
            $this->created_at->addErrorMessage($this->created_at->getErrorMessage(false));
        }
        if ($this->updated_at->Required) {
            if (!$this->updated_at->IsDetailKey && EmptyValue($this->updated_at->FormValue)) {
                $this->updated_at->addErrorMessage(str_replace("%s", $this->updated_at->caption(), $this->updated_at->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->updated_at->FormValue)) {
            $this->updated_at->addErrorMessage($this->updated_at->getErrorMessage(false));
        }

        // Return validate result
        $validateForm = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        $deleteRows = true;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAll($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }

        // Clone old rows
        $rsold = $rows;

        // Call row deleting event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $deleteRows = $this->rowDeleting($row);
                if (!$deleteRows) {
                    break;
                }
            }
        }
        if ($deleteRows) {
            $key = "";
            foreach ($rsold as $row) {
                $thisKey = "";
                if ($thisKey != "") {
                    $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
                }
                $thisKey .= $row['controlObj_name'];
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }
                $deleteRows = $this->delete($row); // Delete
                if ($deleteRows === false) {
                    break;
                }
                if ($key != "") {
                    $key .= ", ";
                }
                $key .= $thisKey;
            }
        }
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }

        // Call Row Deleted event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $this->rowDeleted($row);
            }
        }

        // Write JSON for API request
        if (IsApi() && $deleteRows) {
            $row = $this->getRecordsFromRecordset($rsold);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $deleteRows;
    }

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssoc($sql);
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            $editRow = false; // Update Failed
        } else {
            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // num_ordre
            $this->num_ordre->setDbValueDef($rsnew, $this->num_ordre->CurrentValue, 0, $this->num_ordre->ReadOnly);

            // controlObj_name
            $this->controlObj_name->setDbValueDef($rsnew, $this->controlObj_name->CurrentValue, "", $this->controlObj_name->ReadOnly);

            // question_domain_id
            if ($this->question_domain_id->getSessionValue() != "") {
                $this->question_domain_id->ReadOnly = true;
            }
            $this->question_domain_id->setDbValueDef($rsnew, $this->question_domain_id->CurrentValue, "", $this->question_domain_id->ReadOnly);

            // layer_id
            if ($this->layer_id->getSessionValue() != "") {
                $this->layer_id->ReadOnly = true;
            }
            $this->layer_id->setDbValueDef($rsnew, $this->layer_id->CurrentValue, "", $this->layer_id->ReadOnly);

            // function_csf
            if ($this->function_csf->getSessionValue() != "") {
                $this->function_csf->ReadOnly = true;
            }
            $this->function_csf->setDbValueDef($rsnew, $this->function_csf->CurrentValue, "", $this->function_csf->ReadOnly);

            // created_at
            $this->created_at->setDbValueDef($rsnew, UnFormatDateTime($this->created_at->CurrentValue, 0), null, $this->created_at->ReadOnly);

            // updated_at
            $this->updated_at->setDbValueDef($rsnew, UnFormatDateTime($this->updated_at->CurrentValue, 0), null, $this->updated_at->ReadOnly);

            // Check referential integrity for master table 'question_domains'
            $validMasterRecord = true;
            $masterFilter = $this->sqlMasterFilter_question_domains();
            $keyValue = $rsnew['question_domain_id'] ?? $rsold['question_domain_id'];
            if (strval($keyValue) != "") {
                $masterFilter = str_replace("@domain_name@", AdjustSql($keyValue), $masterFilter);
            } else {
                $validMasterRecord = false;
            }
            if ($validMasterRecord) {
                $rsmaster = Container("question_domains")->loadRs($masterFilter)->fetch();
                $validMasterRecord = $rsmaster !== false;
            }
            if (!$validMasterRecord) {
                $relatedRecordMsg = str_replace("%t", "question_domains", $Language->phrase("RelatedRecordRequired"));
                $this->setFailureMessage($relatedRecordMsg);
                return false;
            }

            // Check referential integrity for master table 'layers'
            $validMasterRecord = true;
            $masterFilter = $this->sqlMasterFilter_layers();
            $keyValue = $rsnew['layer_id'] ?? $rsold['layer_id'];
            if (strval($keyValue) != "") {
                $masterFilter = str_replace("@name@", AdjustSql($keyValue), $masterFilter);
            } else {
                $validMasterRecord = false;
            }
            if ($validMasterRecord) {
                $rsmaster = Container("layers")->loadRs($masterFilter)->fetch();
                $validMasterRecord = $rsmaster !== false;
            }
            if (!$validMasterRecord) {
                $relatedRecordMsg = str_replace("%t", "layers", $Language->phrase("RelatedRecordRequired"));
                $this->setFailureMessage($relatedRecordMsg);
                return false;
            }

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);

            // Check for duplicate key when key changed
            if ($updateRow) {
                $newKeyFilter = $this->getRecordFilter($rsnew);
                if ($newKeyFilter != $oldKeyFilter) {
                    $rsChk = $this->loadRs($newKeyFilter)->fetch();
                    if ($rsChk !== false) {
                        $keyErrMsg = str_replace("%f", $newKeyFilter, $Language->phrase("DupKey"));
                        $this->setFailureMessage($keyErrMsg);
                        $updateRow = false;
                    }
                }
            }
            if ($updateRow) {
                if (count($rsnew) > 0) {
                    $editRow = $this->update($rsnew, "", $rsold);
                } else {
                    $editRow = true; // No field to update
                }
                if ($editRow) {
                }
            } else {
                if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                    // Use the message, do nothing
                } elseif ($this->CancelMessage != "") {
                    $this->setFailureMessage($this->CancelMessage);
                    $this->CancelMessage = "";
                } else {
                    $this->setFailureMessage($Language->phrase("UpdateCancelled"));
                }
                $editRow = false;
            }
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($editRow) {
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Set up foreign key field value from Session
        if ($this->getCurrentMasterTable() == "question_domains") {
            $this->question_domain_id->CurrentValue = $this->question_domain_id->getSessionValue();
        }
        if ($this->getCurrentMasterTable() == "layers") {
            $this->layer_id->CurrentValue = $this->layer_id->getSessionValue();
        }
        if ($this->getCurrentMasterTable() == "functions") {
            $this->function_csf->CurrentValue = $this->function_csf->getSessionValue();
        }

        // Check referential integrity for master table 'question_controlobjectives'
        $validMasterRecord = true;
        $masterFilter = $this->sqlMasterFilter_question_domains();
        if (strval($this->question_domain_id->CurrentValue) != "") {
            $masterFilter = str_replace("@domain_name@", AdjustSql($this->question_domain_id->CurrentValue, "DB"), $masterFilter);
        } else {
            $validMasterRecord = false;
        }
        if ($validMasterRecord) {
            $rsmaster = Container("question_domains")->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "question_domains", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }

        // Check referential integrity for master table 'question_controlobjectives'
        $validMasterRecord = true;
        $masterFilter = $this->sqlMasterFilter_layers();
        if (strval($this->layer_id->CurrentValue) != "") {
            $masterFilter = str_replace("@name@", AdjustSql($this->layer_id->CurrentValue, "DB"), $masterFilter);
        } else {
            $validMasterRecord = false;
        }
        if ($validMasterRecord) {
            $rsmaster = Container("layers")->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "layers", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // num_ordre
        $this->num_ordre->setDbValueDef($rsnew, $this->num_ordre->CurrentValue, 0, false);

        // controlObj_name
        $this->controlObj_name->setDbValueDef($rsnew, $this->controlObj_name->CurrentValue, "", false);

        // question_domain_id
        $this->question_domain_id->setDbValueDef($rsnew, $this->question_domain_id->CurrentValue, "", false);

        // layer_id
        $this->layer_id->setDbValueDef($rsnew, $this->layer_id->CurrentValue, "", false);

        // function_csf
        $this->function_csf->setDbValueDef($rsnew, $this->function_csf->CurrentValue, "", false);

        // created_at
        $this->created_at->setDbValueDef($rsnew, UnFormatDateTime($this->created_at->CurrentValue, 0), null, false);

        // updated_at
        $this->updated_at->setDbValueDef($rsnew, UnFormatDateTime($this->updated_at->CurrentValue, 0), null, false);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['controlObj_name']) == "") {
            $this->setFailureMessage($Language->phrase("InvalidKeyValue"));
            $insertRow = false;
        }

        // Check for duplicate key
        if ($insertRow && $this->ValidateKey) {
            $filter = $this->getRecordFilter($rsnew);
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $keyErrMsg = str_replace("%f", $filter, $Language->phrase("DupKey"));
                $this->setFailureMessage($keyErrMsg);
                $insertRow = false;
            }
        }
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        // Hide foreign keys
        $masterTblVar = $this->getCurrentMasterTable();
        if ($masterTblVar == "question_domains") {
            $masterTbl = Container("question_domains");
            $this->question_domain_id->Visible = false;
            if ($masterTbl->EventCancelled) {
                $this->EventCancelled = true;
            }
        }
        if ($masterTblVar == "layers") {
            $masterTbl = Container("layers");
            $this->layer_id->Visible = false;
            if ($masterTbl->EventCancelled) {
                $this->EventCancelled = true;
            }
        }
        if ($masterTblVar == "functions") {
            $masterTbl = Container("functions");
            $this->function_csf->Visible = false;
            if ($masterTbl->EventCancelled) {
                $this->EventCancelled = true;
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_question_domain_id":
                    break;
                case "x_layer_id":
                    break;
                case "x_function_csf":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if ($fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll(\PDO::FETCH_BOTH);
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row);
                    $ar[strval($row[0])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in CustomError
        return true;
    }

    // ListOptions Load event
    public function listOptionsLoad()
    {
        // Example:
        //$opt = &$this->ListOptions->Add("new");
        //$opt->Header = "xxx";
        //$opt->OnLeft = true; // Link on left
        //$opt->MoveTo(0); // Move to first column
    }

    // ListOptions Rendering event
    public function listOptionsRendering()
    {
        //Container("DetailTableGrid")->DetailAdd = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailEdit = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailView = (...condition...); // Set to true or false conditionally
    }

    // ListOptions Rendered event
    public function listOptionsRendered()
    {
        // Example:
        //$this->ListOptions["new"]->Body = "xxx";
    }
}
