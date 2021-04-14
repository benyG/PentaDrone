<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NistRefsAdd extends NistRefs
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'nist_refs';

    // Page object name
    public $PageObjName = "NistRefsAdd";

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

        // Table object (nist_refs)
        if (!isset($GLOBALS["nist_refs"]) || get_class($GLOBALS["nist_refs"]) == PROJECT_NAMESPACE . "nist_refs") {
            $GLOBALS["nist_refs"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'nist_refs');
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
                $doc = new $class(Container("nist_refs"));
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
                    if ($pageName == "NistRefsView") {
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
            $key .= @$ar['Nidentifier'];
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
        $this->Nidentifier->setVisibility();
        $this->N_ordre->setVisibility();
        $this->Control_Family_id->setVisibility();
        $this->Control_Name->setVisibility();
        $this->control_description->setVisibility();
        $this->discussion->setVisibility();
        $this->related_controls->setVisibility();
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
            if (($keyValue = Get("Nidentifier") ?? Route("Nidentifier")) !== null) {
                $this->Nidentifier->setQueryStringValue($keyValue);
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
                    $this->terminate("NistRefsList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "NistRefsList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "NistRefsView") {
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
        $this->Nidentifier->CurrentValue = null;
        $this->Nidentifier->OldValue = $this->Nidentifier->CurrentValue;
        $this->N_ordre->CurrentValue = null;
        $this->N_ordre->OldValue = $this->N_ordre->CurrentValue;
        $this->Control_Family_id->CurrentValue = null;
        $this->Control_Family_id->OldValue = $this->Control_Family_id->CurrentValue;
        $this->Control_Name->CurrentValue = null;
        $this->Control_Name->OldValue = $this->Control_Name->CurrentValue;
        $this->control_description->CurrentValue = null;
        $this->control_description->OldValue = $this->control_description->CurrentValue;
        $this->discussion->CurrentValue = null;
        $this->discussion->OldValue = $this->discussion->CurrentValue;
        $this->related_controls->CurrentValue = null;
        $this->related_controls->OldValue = $this->related_controls->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'Nidentifier' first before field var 'x_Nidentifier'
        $val = $CurrentForm->hasValue("Nidentifier") ? $CurrentForm->getValue("Nidentifier") : $CurrentForm->getValue("x_Nidentifier");
        if (!$this->Nidentifier->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nidentifier->Visible = false; // Disable update for API request
            } else {
                $this->Nidentifier->setFormValue($val);
            }
        }

        // Check field name 'N_ordre' first before field var 'x_N_ordre'
        $val = $CurrentForm->hasValue("N_ordre") ? $CurrentForm->getValue("N_ordre") : $CurrentForm->getValue("x_N_ordre");
        if (!$this->N_ordre->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->N_ordre->Visible = false; // Disable update for API request
            } else {
                $this->N_ordre->setFormValue($val);
            }
        }

        // Check field name 'Control_Family_id' first before field var 'x_Control_Family_id'
        $val = $CurrentForm->hasValue("Control_Family_id") ? $CurrentForm->getValue("Control_Family_id") : $CurrentForm->getValue("x_Control_Family_id");
        if (!$this->Control_Family_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Control_Family_id->Visible = false; // Disable update for API request
            } else {
                $this->Control_Family_id->setFormValue($val);
            }
        }

        // Check field name 'Control_Name' first before field var 'x_Control_Name'
        $val = $CurrentForm->hasValue("Control_Name") ? $CurrentForm->getValue("Control_Name") : $CurrentForm->getValue("x_Control_Name");
        if (!$this->Control_Name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Control_Name->Visible = false; // Disable update for API request
            } else {
                $this->Control_Name->setFormValue($val);
            }
        }

        // Check field name 'control_description' first before field var 'x_control_description'
        $val = $CurrentForm->hasValue("control_description") ? $CurrentForm->getValue("control_description") : $CurrentForm->getValue("x_control_description");
        if (!$this->control_description->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->control_description->Visible = false; // Disable update for API request
            } else {
                $this->control_description->setFormValue($val);
            }
        }

        // Check field name 'discussion' first before field var 'x_discussion'
        $val = $CurrentForm->hasValue("discussion") ? $CurrentForm->getValue("discussion") : $CurrentForm->getValue("x_discussion");
        if (!$this->discussion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->discussion->Visible = false; // Disable update for API request
            } else {
                $this->discussion->setFormValue($val);
            }
        }

        // Check field name 'related_controls' first before field var 'x_related_controls'
        $val = $CurrentForm->hasValue("related_controls") ? $CurrentForm->getValue("related_controls") : $CurrentForm->getValue("x_related_controls");
        if (!$this->related_controls->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->related_controls->Visible = false; // Disable update for API request
            } else {
                $this->related_controls->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->Nidentifier->CurrentValue = $this->Nidentifier->FormValue;
        $this->N_ordre->CurrentValue = $this->N_ordre->FormValue;
        $this->Control_Family_id->CurrentValue = $this->Control_Family_id->FormValue;
        $this->Control_Name->CurrentValue = $this->Control_Name->FormValue;
        $this->control_description->CurrentValue = $this->control_description->FormValue;
        $this->discussion->CurrentValue = $this->discussion->FormValue;
        $this->related_controls->CurrentValue = $this->related_controls->FormValue;
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
        $this->Nidentifier->setDbValue($row['Nidentifier']);
        $this->N_ordre->setDbValue($row['N_ordre']);
        $this->Control_Family_id->setDbValue($row['Control_Family_id']);
        $this->Control_Name->setDbValue($row['Control_Name']);
        $this->control_description->setDbValue($row['control_description']);
        $this->discussion->setDbValue($row['discussion']);
        $this->related_controls->setDbValue($row['related_controls']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['Nidentifier'] = $this->Nidentifier->CurrentValue;
        $row['N_ordre'] = $this->N_ordre->CurrentValue;
        $row['Control_Family_id'] = $this->Control_Family_id->CurrentValue;
        $row['Control_Name'] = $this->Control_Name->CurrentValue;
        $row['control_description'] = $this->control_description->CurrentValue;
        $row['discussion'] = $this->discussion->CurrentValue;
        $row['related_controls'] = $this->related_controls->CurrentValue;
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

        // Nidentifier

        // N_ordre

        // Control_Family_id

        // Control_Name

        // control_description

        // discussion

        // related_controls
        if ($this->RowType == ROWTYPE_VIEW) {
            // Nidentifier
            $this->Nidentifier->ViewValue = $this->Nidentifier->CurrentValue;
            $this->Nidentifier->ViewCustomAttributes = "";

            // N_ordre
            $this->N_ordre->ViewValue = $this->N_ordre->CurrentValue;
            $this->N_ordre->ViewValue = FormatNumber($this->N_ordre->ViewValue, 0, -2, -2, -2);
            $this->N_ordre->ViewCustomAttributes = "";

            // Control_Family_id
            $this->Control_Family_id->ViewValue = $this->Control_Family_id->CurrentValue;
            $this->Control_Family_id->ViewCustomAttributes = "";

            // Control_Name
            $this->Control_Name->ViewValue = $this->Control_Name->CurrentValue;
            $this->Control_Name->ViewCustomAttributes = "";

            // control_description
            $this->control_description->ViewValue = $this->control_description->CurrentValue;
            $this->control_description->ViewCustomAttributes = "";

            // discussion
            $this->discussion->ViewValue = $this->discussion->CurrentValue;
            $this->discussion->ViewCustomAttributes = "";

            // related_controls
            $this->related_controls->ViewValue = $this->related_controls->CurrentValue;
            $this->related_controls->ViewCustomAttributes = "";

            // Nidentifier
            $this->Nidentifier->LinkCustomAttributes = "";
            $this->Nidentifier->HrefValue = "";
            $this->Nidentifier->TooltipValue = "";

            // N_ordre
            $this->N_ordre->LinkCustomAttributes = "";
            $this->N_ordre->HrefValue = "";
            $this->N_ordre->TooltipValue = "";

            // Control_Family_id
            $this->Control_Family_id->LinkCustomAttributes = "";
            $this->Control_Family_id->HrefValue = "";
            $this->Control_Family_id->TooltipValue = "";

            // Control_Name
            $this->Control_Name->LinkCustomAttributes = "";
            $this->Control_Name->HrefValue = "";
            $this->Control_Name->TooltipValue = "";

            // control_description
            $this->control_description->LinkCustomAttributes = "";
            $this->control_description->HrefValue = "";
            $this->control_description->TooltipValue = "";

            // discussion
            $this->discussion->LinkCustomAttributes = "";
            $this->discussion->HrefValue = "";
            $this->discussion->TooltipValue = "";

            // related_controls
            $this->related_controls->LinkCustomAttributes = "";
            $this->related_controls->HrefValue = "";
            $this->related_controls->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // Nidentifier
            $this->Nidentifier->EditAttrs["class"] = "form-control";
            $this->Nidentifier->EditCustomAttributes = "";
            if (!$this->Nidentifier->Raw) {
                $this->Nidentifier->CurrentValue = HtmlDecode($this->Nidentifier->CurrentValue);
            }
            $this->Nidentifier->EditValue = HtmlEncode($this->Nidentifier->CurrentValue);
            $this->Nidentifier->PlaceHolder = RemoveHtml($this->Nidentifier->caption());

            // N_ordre
            $this->N_ordre->EditAttrs["class"] = "form-control";
            $this->N_ordre->EditCustomAttributes = "";
            $this->N_ordre->EditValue = HtmlEncode($this->N_ordre->CurrentValue);
            $this->N_ordre->PlaceHolder = RemoveHtml($this->N_ordre->caption());

            // Control_Family_id
            $this->Control_Family_id->EditAttrs["class"] = "form-control";
            $this->Control_Family_id->EditCustomAttributes = "";
            if ($this->Control_Family_id->getSessionValue() != "") {
                $this->Control_Family_id->CurrentValue = GetForeignKeyValue($this->Control_Family_id->getSessionValue());
                $this->Control_Family_id->ViewValue = $this->Control_Family_id->CurrentValue;
                $this->Control_Family_id->ViewCustomAttributes = "";
            } else {
                if (!$this->Control_Family_id->Raw) {
                    $this->Control_Family_id->CurrentValue = HtmlDecode($this->Control_Family_id->CurrentValue);
                }
                $this->Control_Family_id->EditValue = HtmlEncode($this->Control_Family_id->CurrentValue);
                $this->Control_Family_id->PlaceHolder = RemoveHtml($this->Control_Family_id->caption());
            }

            // Control_Name
            $this->Control_Name->EditAttrs["class"] = "form-control";
            $this->Control_Name->EditCustomAttributes = "";
            if (!$this->Control_Name->Raw) {
                $this->Control_Name->CurrentValue = HtmlDecode($this->Control_Name->CurrentValue);
            }
            $this->Control_Name->EditValue = HtmlEncode($this->Control_Name->CurrentValue);
            $this->Control_Name->PlaceHolder = RemoveHtml($this->Control_Name->caption());

            // control_description
            $this->control_description->EditAttrs["class"] = "form-control";
            $this->control_description->EditCustomAttributes = "";
            $this->control_description->EditValue = HtmlEncode($this->control_description->CurrentValue);
            $this->control_description->PlaceHolder = RemoveHtml($this->control_description->caption());

            // discussion
            $this->discussion->EditAttrs["class"] = "form-control";
            $this->discussion->EditCustomAttributes = "";
            $this->discussion->EditValue = HtmlEncode($this->discussion->CurrentValue);
            $this->discussion->PlaceHolder = RemoveHtml($this->discussion->caption());

            // related_controls
            $this->related_controls->EditAttrs["class"] = "form-control";
            $this->related_controls->EditCustomAttributes = "";
            $this->related_controls->EditValue = HtmlEncode($this->related_controls->CurrentValue);
            $this->related_controls->PlaceHolder = RemoveHtml($this->related_controls->caption());

            // Add refer script

            // Nidentifier
            $this->Nidentifier->LinkCustomAttributes = "";
            $this->Nidentifier->HrefValue = "";

            // N_ordre
            $this->N_ordre->LinkCustomAttributes = "";
            $this->N_ordre->HrefValue = "";

            // Control_Family_id
            $this->Control_Family_id->LinkCustomAttributes = "";
            $this->Control_Family_id->HrefValue = "";

            // Control_Name
            $this->Control_Name->LinkCustomAttributes = "";
            $this->Control_Name->HrefValue = "";

            // control_description
            $this->control_description->LinkCustomAttributes = "";
            $this->control_description->HrefValue = "";

            // discussion
            $this->discussion->LinkCustomAttributes = "";
            $this->discussion->HrefValue = "";

            // related_controls
            $this->related_controls->LinkCustomAttributes = "";
            $this->related_controls->HrefValue = "";
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
        if ($this->Nidentifier->Required) {
            if (!$this->Nidentifier->IsDetailKey && EmptyValue($this->Nidentifier->FormValue)) {
                $this->Nidentifier->addErrorMessage(str_replace("%s", $this->Nidentifier->caption(), $this->Nidentifier->RequiredErrorMessage));
            }
        }
        if ($this->N_ordre->Required) {
            if (!$this->N_ordre->IsDetailKey && EmptyValue($this->N_ordre->FormValue)) {
                $this->N_ordre->addErrorMessage(str_replace("%s", $this->N_ordre->caption(), $this->N_ordre->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->N_ordre->FormValue)) {
            $this->N_ordre->addErrorMessage($this->N_ordre->getErrorMessage(false));
        }
        if ($this->Control_Family_id->Required) {
            if (!$this->Control_Family_id->IsDetailKey && EmptyValue($this->Control_Family_id->FormValue)) {
                $this->Control_Family_id->addErrorMessage(str_replace("%s", $this->Control_Family_id->caption(), $this->Control_Family_id->RequiredErrorMessage));
            }
        }
        if ($this->Control_Name->Required) {
            if (!$this->Control_Name->IsDetailKey && EmptyValue($this->Control_Name->FormValue)) {
                $this->Control_Name->addErrorMessage(str_replace("%s", $this->Control_Name->caption(), $this->Control_Name->RequiredErrorMessage));
            }
        }
        if ($this->control_description->Required) {
            if (!$this->control_description->IsDetailKey && EmptyValue($this->control_description->FormValue)) {
                $this->control_description->addErrorMessage(str_replace("%s", $this->control_description->caption(), $this->control_description->RequiredErrorMessage));
            }
        }
        if ($this->discussion->Required) {
            if (!$this->discussion->IsDetailKey && EmptyValue($this->discussion->FormValue)) {
                $this->discussion->addErrorMessage(str_replace("%s", $this->discussion->caption(), $this->discussion->RequiredErrorMessage));
            }
        }
        if ($this->related_controls->Required) {
            if (!$this->related_controls->IsDetailKey && EmptyValue($this->related_controls->FormValue)) {
                $this->related_controls->addErrorMessage(str_replace("%s", $this->related_controls->caption(), $this->related_controls->RequiredErrorMessage));
            }
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

        // Check referential integrity for master table 'nist_refs'
        $validMasterRecord = true;
        $masterFilter = $this->sqlMasterFilter_nist_refs_controlfamily();
        if (strval($this->Control_Family_id->CurrentValue) != "") {
            $masterFilter = str_replace("@code@", AdjustSql($this->Control_Family_id->CurrentValue, "DB"), $masterFilter);
        } else {
            $validMasterRecord = false;
        }
        if ($validMasterRecord) {
            $rsmaster = Container("nist_refs_controlfamily")->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "nist_refs_controlfamily", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // Nidentifier
        $this->Nidentifier->setDbValueDef($rsnew, $this->Nidentifier->CurrentValue, "", false);

        // N_ordre
        $this->N_ordre->setDbValueDef($rsnew, $this->N_ordre->CurrentValue, null, false);

        // Control_Family_id
        $this->Control_Family_id->setDbValueDef($rsnew, $this->Control_Family_id->CurrentValue, null, false);

        // Control_Name
        $this->Control_Name->setDbValueDef($rsnew, $this->Control_Name->CurrentValue, null, false);

        // control_description
        $this->control_description->setDbValueDef($rsnew, $this->control_description->CurrentValue, null, false);

        // discussion
        $this->discussion->setDbValueDef($rsnew, $this->discussion->CurrentValue, null, false);

        // related_controls
        $this->related_controls->setDbValueDef($rsnew, $this->related_controls->CurrentValue, null, false);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['Nidentifier']) == "") {
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
                if (($parm = Get("fk_code", Get("Control_Family_id"))) !== null) {
                    $masterTbl->code->setQueryStringValue($parm);
                    $this->Control_Family_id->setQueryStringValue($masterTbl->code->QueryStringValue);
                    $this->Control_Family_id->setSessionValue($this->Control_Family_id->QueryStringValue);
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
                if (($parm = Post("fk_code", Post("Control_Family_id"))) !== null) {
                    $masterTbl->code->setFormValue($parm);
                    $this->Control_Family_id->setFormValue($masterTbl->code->FormValue);
                    $this->Control_Family_id->setSessionValue($this->Control_Family_id->FormValue);
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
                if ($this->Control_Family_id->CurrentValue == "") {
                    $this->Control_Family_id->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("NistRefsList"), "", $this->TableVar, true);
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
