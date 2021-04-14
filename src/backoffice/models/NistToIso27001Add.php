<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NistToIso27001Add extends NistToIso27001
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'nist_to_iso27001';

    // Page object name
    public $PageObjName = "NistToIso27001Add";

    // Rendering View
    public $RenderingView = false;

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
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (nist_to_iso27001)
        if (!isset($GLOBALS["nist_to_iso27001"]) || get_class($GLOBALS["nist_to_iso27001"]) == PROJECT_NAMESPACE . "nist_to_iso27001") {
            $GLOBALS["nist_to_iso27001"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'nist_to_iso27001');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();
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

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $doc = new $class(Container("nist_to_iso27001"));
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
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "NistToIso27001View") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
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
            $key .= @$ar['id'];
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
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->id->Visible = false;
        }
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
    public $FormClassName = "ew-horizontal ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $OldRecordset;
    public $CopyRecord;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->Visible = false;
        $this->nistrefs_family->setVisibility();
        $this->isorefs->setVisibility();
        $this->created_at->setVisibility();
        $this->updated_at->setVisibility();
        $this->just_for_question_link->setVisibility();
        $this->hideFieldsForAddEdit();

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->nistrefs_family);
        $this->setupLookupOptions($this->isorefs);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-add-form ew-horizontal";
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("id") ?? Route("id")) !== null) {
                $this->id->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record / default values
        $loaded = $this->loadOldRecord();

        // Set up master/detail parameters
        // NOTE: must be after loadOldRecord to prevent master key values overwritten
        $this->setupMasterParms();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Set up detail parameters
        $this->setupDetailParms();

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$loaded) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("NistToIso27001List"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    if ($this->getCurrentDetailTable() != "") { // Master/detail add
                        $returnUrl = $this->getDetailUrl();
                    } else {
                        $returnUrl = $this->getReturnUrl();
                    }
                    if (GetPageName($returnUrl) == "NistToIso27001List") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "NistToIso27001View") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values

                    // Set up detail parameters
                    $this->setupDetailParms();
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = ROWTYPE_ADD; // Render add type

        // Render row
        $this->resetAttributes();
        $this->renderRow();

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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->nistrefs_family->CurrentValue = null;
        $this->nistrefs_family->OldValue = $this->nistrefs_family->CurrentValue;
        $this->isorefs->CurrentValue = null;
        $this->isorefs->OldValue = $this->isorefs->CurrentValue;
        $this->created_at->CurrentValue = null;
        $this->created_at->OldValue = $this->created_at->CurrentValue;
        $this->updated_at->CurrentValue = null;
        $this->updated_at->OldValue = $this->updated_at->CurrentValue;
        $this->just_for_question_link->CurrentValue = null;
        $this->just_for_question_link->OldValue = $this->just_for_question_link->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'nistrefs_family' first before field var 'x_nistrefs_family'
        $val = $CurrentForm->hasValue("nistrefs_family") ? $CurrentForm->getValue("nistrefs_family") : $CurrentForm->getValue("x_nistrefs_family");
        if (!$this->nistrefs_family->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nistrefs_family->Visible = false; // Disable update for API request
            } else {
                $this->nistrefs_family->setFormValue($val);
            }
        }

        // Check field name 'isorefs' first before field var 'x_isorefs'
        $val = $CurrentForm->hasValue("isorefs") ? $CurrentForm->getValue("isorefs") : $CurrentForm->getValue("x_isorefs");
        if (!$this->isorefs->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isorefs->Visible = false; // Disable update for API request
            } else {
                $this->isorefs->setFormValue($val);
            }
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

        // Check field name 'just_for_question_link' first before field var 'x_just_for_question_link'
        $val = $CurrentForm->hasValue("just_for_question_link") ? $CurrentForm->getValue("just_for_question_link") : $CurrentForm->getValue("x_just_for_question_link");
        if (!$this->just_for_question_link->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->just_for_question_link->Visible = false; // Disable update for API request
            } else {
                $this->just_for_question_link->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->nistrefs_family->CurrentValue = $this->nistrefs_family->FormValue;
        $this->isorefs->CurrentValue = $this->isorefs->FormValue;
        $this->created_at->CurrentValue = $this->created_at->FormValue;
        $this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, 0);
        $this->updated_at->CurrentValue = $this->updated_at->FormValue;
        $this->updated_at->CurrentValue = UnFormatDateTime($this->updated_at->CurrentValue, 0);
        $this->just_for_question_link->CurrentValue = $this->just_for_question_link->FormValue;
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
        $this->id->setDbValue($row['id']);
        $this->nistrefs_family->setDbValue($row['nistrefs_family']);
        if (array_key_exists('EV__nistrefs_family', $row)) {
            $this->nistrefs_family->VirtualValue = $row['EV__nistrefs_family']; // Set up virtual field value
        } else {
            $this->nistrefs_family->VirtualValue = ""; // Clear value
        }
        $this->isorefs->setDbValue($row['isorefs']);
        if (array_key_exists('EV__isorefs', $row)) {
            $this->isorefs->VirtualValue = $row['EV__isorefs']; // Set up virtual field value
        } else {
            $this->isorefs->VirtualValue = ""; // Clear value
        }
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
        $this->just_for_question_link->setDbValue($row['just_for_question_link']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['nistrefs_family'] = $this->nistrefs_family->CurrentValue;
        $row['isorefs'] = $this->isorefs->CurrentValue;
        $row['created_at'] = $this->created_at->CurrentValue;
        $row['updated_at'] = $this->updated_at->CurrentValue;
        $row['just_for_question_link'] = $this->just_for_question_link->CurrentValue;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // nistrefs_family

        // isorefs

        // created_at

        // updated_at

        // just_for_question_link
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // nistrefs_family
            if ($this->nistrefs_family->VirtualValue != "") {
                $this->nistrefs_family->ViewValue = $this->nistrefs_family->VirtualValue;
            } else {
                $curVal = strval($this->nistrefs_family->CurrentValue);
                if ($curVal != "") {
                    $this->nistrefs_family->ViewValue = $this->nistrefs_family->lookupCacheOption($curVal);
                    if ($this->nistrefs_family->ViewValue === null) { // Lookup from database
                        $filterWrk = "`code`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                        $sqlWrk = $this->nistrefs_family->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->nistrefs_family->Lookup->renderViewRow($rswrk[0]);
                            $this->nistrefs_family->ViewValue = $this->nistrefs_family->displayValue($arwrk);
                        } else {
                            $this->nistrefs_family->ViewValue = $this->nistrefs_family->CurrentValue;
                        }
                    }
                } else {
                    $this->nistrefs_family->ViewValue = null;
                }
            }
            $this->nistrefs_family->ViewCustomAttributes = "";

            // isorefs
            if ($this->isorefs->VirtualValue != "") {
                $this->isorefs->ViewValue = $this->isorefs->VirtualValue;
            } else {
                $curVal = strval($this->isorefs->CurrentValue);
                if ($curVal != "") {
                    $this->isorefs->ViewValue = $this->isorefs->lookupCacheOption($curVal);
                    if ($this->isorefs->ViewValue === null) { // Lookup from database
                        $filterWrk = "`code`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                        $sqlWrk = $this->isorefs->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->isorefs->Lookup->renderViewRow($rswrk[0]);
                            $this->isorefs->ViewValue = $this->isorefs->displayValue($arwrk);
                        } else {
                            $this->isorefs->ViewValue = $this->isorefs->CurrentValue;
                        }
                    }
                } else {
                    $this->isorefs->ViewValue = null;
                }
            }
            $this->isorefs->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
            $this->updated_at->ViewCustomAttributes = "";

            // just_for_question_link
            $this->just_for_question_link->ViewValue = $this->just_for_question_link->CurrentValue;
            $this->just_for_question_link->ViewCustomAttributes = "";

            // nistrefs_family
            $this->nistrefs_family->LinkCustomAttributes = "";
            $this->nistrefs_family->HrefValue = "";
            $this->nistrefs_family->TooltipValue = "";

            // isorefs
            $this->isorefs->LinkCustomAttributes = "";
            $this->isorefs->HrefValue = "";
            $this->isorefs->TooltipValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";
            $this->created_at->TooltipValue = "";

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";
            $this->updated_at->TooltipValue = "";

            // just_for_question_link
            $this->just_for_question_link->LinkCustomAttributes = "";
            $this->just_for_question_link->HrefValue = "";
            $this->just_for_question_link->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // nistrefs_family
            $this->nistrefs_family->EditAttrs["class"] = "form-control";
            $this->nistrefs_family->EditCustomAttributes = "";
            if ($this->nistrefs_family->getSessionValue() != "") {
                $this->nistrefs_family->CurrentValue = GetForeignKeyValue($this->nistrefs_family->getSessionValue());
                if ($this->nistrefs_family->VirtualValue != "") {
                    $this->nistrefs_family->ViewValue = $this->nistrefs_family->VirtualValue;
                } else {
                    $curVal = strval($this->nistrefs_family->CurrentValue);
                    if ($curVal != "") {
                        $this->nistrefs_family->ViewValue = $this->nistrefs_family->lookupCacheOption($curVal);
                        if ($this->nistrefs_family->ViewValue === null) { // Lookup from database
                            $filterWrk = "`code`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                            $sqlWrk = $this->nistrefs_family->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                            $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                            $ari = count($rswrk);
                            if ($ari > 0) { // Lookup values found
                                $arwrk = $this->nistrefs_family->Lookup->renderViewRow($rswrk[0]);
                                $this->nistrefs_family->ViewValue = $this->nistrefs_family->displayValue($arwrk);
                            } else {
                                $this->nistrefs_family->ViewValue = $this->nistrefs_family->CurrentValue;
                            }
                        }
                    } else {
                        $this->nistrefs_family->ViewValue = null;
                    }
                }
                $this->nistrefs_family->ViewCustomAttributes = "";
            } else {
                $curVal = trim(strval($this->nistrefs_family->CurrentValue));
                if ($curVal != "") {
                    $this->nistrefs_family->ViewValue = $this->nistrefs_family->lookupCacheOption($curVal);
                } else {
                    $this->nistrefs_family->ViewValue = $this->nistrefs_family->Lookup !== null && is_array($this->nistrefs_family->Lookup->Options) ? $curVal : null;
                }
                if ($this->nistrefs_family->ViewValue !== null) { // Load from cache
                    $this->nistrefs_family->EditValue = array_values($this->nistrefs_family->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`code`" . SearchString("=", $this->nistrefs_family->CurrentValue, DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->nistrefs_family->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->nistrefs_family->EditValue = $arwrk;
                }
                $this->nistrefs_family->PlaceHolder = RemoveHtml($this->nistrefs_family->caption());
            }

            // isorefs
            $this->isorefs->EditAttrs["class"] = "form-control";
            $this->isorefs->EditCustomAttributes = "";
            if ($this->isorefs->getSessionValue() != "") {
                $this->isorefs->CurrentValue = GetForeignKeyValue($this->isorefs->getSessionValue());
                if ($this->isorefs->VirtualValue != "") {
                    $this->isorefs->ViewValue = $this->isorefs->VirtualValue;
                } else {
                    $curVal = strval($this->isorefs->CurrentValue);
                    if ($curVal != "") {
                        $this->isorefs->ViewValue = $this->isorefs->lookupCacheOption($curVal);
                        if ($this->isorefs->ViewValue === null) { // Lookup from database
                            $filterWrk = "`code`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                            $sqlWrk = $this->isorefs->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                            $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                            $ari = count($rswrk);
                            if ($ari > 0) { // Lookup values found
                                $arwrk = $this->isorefs->Lookup->renderViewRow($rswrk[0]);
                                $this->isorefs->ViewValue = $this->isorefs->displayValue($arwrk);
                            } else {
                                $this->isorefs->ViewValue = $this->isorefs->CurrentValue;
                            }
                        }
                    } else {
                        $this->isorefs->ViewValue = null;
                    }
                }
                $this->isorefs->ViewCustomAttributes = "";
            } else {
                $curVal = trim(strval($this->isorefs->CurrentValue));
                if ($curVal != "") {
                    $this->isorefs->ViewValue = $this->isorefs->lookupCacheOption($curVal);
                } else {
                    $this->isorefs->ViewValue = $this->isorefs->Lookup !== null && is_array($this->isorefs->Lookup->Options) ? $curVal : null;
                }
                if ($this->isorefs->ViewValue !== null) { // Load from cache
                    $this->isorefs->EditValue = array_values($this->isorefs->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`code`" . SearchString("=", $this->isorefs->CurrentValue, DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->isorefs->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->isorefs->EditValue = $arwrk;
                }
                $this->isorefs->PlaceHolder = RemoveHtml($this->isorefs->caption());
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

            // just_for_question_link
            $this->just_for_question_link->EditAttrs["class"] = "form-control";
            $this->just_for_question_link->EditCustomAttributes = "";
            if (!$this->just_for_question_link->Raw) {
                $this->just_for_question_link->CurrentValue = HtmlDecode($this->just_for_question_link->CurrentValue);
            }
            $this->just_for_question_link->EditValue = HtmlEncode($this->just_for_question_link->CurrentValue);
            $this->just_for_question_link->PlaceHolder = RemoveHtml($this->just_for_question_link->caption());

            // Add refer script

            // nistrefs_family
            $this->nistrefs_family->LinkCustomAttributes = "";
            $this->nistrefs_family->HrefValue = "";

            // isorefs
            $this->isorefs->LinkCustomAttributes = "";
            $this->isorefs->HrefValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";

            // just_for_question_link
            $this->just_for_question_link->LinkCustomAttributes = "";
            $this->just_for_question_link->HrefValue = "";
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
        if ($this->nistrefs_family->Required) {
            if (!$this->nistrefs_family->IsDetailKey && EmptyValue($this->nistrefs_family->FormValue)) {
                $this->nistrefs_family->addErrorMessage(str_replace("%s", $this->nistrefs_family->caption(), $this->nistrefs_family->RequiredErrorMessage));
            }
        }
        if ($this->isorefs->Required) {
            if (!$this->isorefs->IsDetailKey && EmptyValue($this->isorefs->FormValue)) {
                $this->isorefs->addErrorMessage(str_replace("%s", $this->isorefs->caption(), $this->isorefs->RequiredErrorMessage));
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
        if ($this->just_for_question_link->Required) {
            if (!$this->just_for_question_link->IsDetailKey && EmptyValue($this->just_for_question_link->FormValue)) {
                $this->just_for_question_link->addErrorMessage(str_replace("%s", $this->just_for_question_link->caption(), $this->just_for_question_link->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("QuestionsLibraryGrid");
        if (in_array("questions_library", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
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

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;
        $conn = $this->getConnection();

        // Begin transaction
        if ($this->getCurrentDetailTable() != "") {
            $conn->beginTransaction();
        }

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // nistrefs_family
        $this->nistrefs_family->setDbValueDef($rsnew, $this->nistrefs_family->CurrentValue, "", false);

        // isorefs
        $this->isorefs->setDbValueDef($rsnew, $this->isorefs->CurrentValue, "", false);

        // created_at
        $this->created_at->setDbValueDef($rsnew, UnFormatDateTime($this->created_at->CurrentValue, 0), null, false);

        // updated_at
        $this->updated_at->setDbValueDef($rsnew, UnFormatDateTime($this->updated_at->CurrentValue, 0), null, false);

        // just_for_question_link
        $this->just_for_question_link->setDbValueDef($rsnew, $this->just_for_question_link->CurrentValue, "", false);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
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

        // Add detail records
        if ($addRow) {
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("QuestionsLibraryGrid");
            if (in_array("questions_library", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->refs1->setSessionValue($this->just_for_question_link->CurrentValue); // Set master key
                $addRow = $detailPage->gridInsert();
                if (!$addRow) {
                $detailPage->refs1->setSessionValue(""); // Clear master key if insert failed
                }
            }
        }

        // Commit/Rollback transaction
        if ($this->getCurrentDetailTable() != "") {
            if ($addRow) {
                $conn->commit(); // Commit transaction
            } else {
                $conn->rollback(); // Rollback transaction
            }
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
        $validMaster = false;
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "nist_refs_controlfamily") {
                $validMaster = true;
                $masterTbl = Container("nist_refs_controlfamily");
                if (($parm = Get("fk_code", Get("nistrefs_family"))) !== null) {
                    $masterTbl->code->setQueryStringValue($parm);
                    $this->nistrefs_family->setQueryStringValue($masterTbl->code->QueryStringValue);
                    $this->nistrefs_family->setSessionValue($this->nistrefs_family->QueryStringValue);
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "iso27001_refs") {
                $validMaster = true;
                $masterTbl = Container("iso27001_refs");
                if (($parm = Get("fk_control_ID", Get("isorefs"))) !== null) {
                    $masterTbl->control_ID->setQueryStringValue($parm);
                    $this->isorefs->setQueryStringValue($masterTbl->control_ID->QueryStringValue);
                    $this->isorefs->setSessionValue($this->isorefs->QueryStringValue);
                } else {
                    $validMaster = false;
                }
            }
        } elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                    $validMaster = true;
                    $this->DbMasterFilter = "";
                    $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "nist_refs_controlfamily") {
                $validMaster = true;
                $masterTbl = Container("nist_refs_controlfamily");
                if (($parm = Post("fk_code", Post("nistrefs_family"))) !== null) {
                    $masterTbl->code->setFormValue($parm);
                    $this->nistrefs_family->setFormValue($masterTbl->code->FormValue);
                    $this->nistrefs_family->setSessionValue($this->nistrefs_family->FormValue);
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "iso27001_refs") {
                $validMaster = true;
                $masterTbl = Container("iso27001_refs");
                if (($parm = Post("fk_control_ID", Post("isorefs"))) !== null) {
                    $masterTbl->control_ID->setFormValue($parm);
                    $this->isorefs->setFormValue($masterTbl->control_ID->FormValue);
                    $this->isorefs->setSessionValue($this->isorefs->FormValue);
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "nist_refs_controlfamily") {
                if ($this->nistrefs_family->CurrentValue == "") {
                    $this->nistrefs_family->setSessionValue("");
                }
            }
            if ($masterTblVar != "iso27001_refs") {
                if ($this->isorefs->CurrentValue == "") {
                    $this->isorefs->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
    }

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("questions_library", $detailTblVar)) {
                $detailPageObj = Container("QuestionsLibraryGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->refs1->IsDetailKey = true;
                    $detailPageObj->refs1->CurrentValue = $this->just_for_question_link->CurrentValue;
                    $detailPageObj->refs1->setSessionValue($detailPageObj->refs1->CurrentValue);
                    $detailPageObj->controlObj_id->setSessionValue(""); // Clear session key
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("NistToIso27001List"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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
                case "x_nistrefs_family":
                    break;
                case "x_isorefs":
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
}
