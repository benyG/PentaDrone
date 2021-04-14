<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class QuestionControlobjectivesAdd extends QuestionControlobjectives
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'question_controlobjectives';

    // Page object name
    public $PageObjName = "QuestionControlobjectivesAdd";

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

        // Table object (question_controlobjectives)
        if (!isset($GLOBALS["question_controlobjectives"]) || get_class($GLOBALS["question_controlobjectives"]) == PROJECT_NAMESPACE . "question_controlobjectives") {
            $GLOBALS["question_controlobjectives"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

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
                    if ($pageName == "QuestionControlobjectivesView") {
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
        $this->num_ordre->setVisibility();
        $this->controlObj_name->setVisibility();
        $this->question_domain_id->setVisibility();
        $this->layer_id->setVisibility();
        $this->function_csf->setVisibility();
        $this->created_at->setVisibility();
        $this->updated_at->setVisibility();
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
        $this->setupLookupOptions($this->question_domain_id);
        $this->setupLookupOptions($this->layer_id);
        $this->setupLookupOptions($this->function_csf);

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
            if (($keyValue = Get("controlObj_name") ?? Route("controlObj_name")) !== null) {
                $this->controlObj_name->setQueryStringValue($keyValue);
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
                    $this->terminate("QuestionControlobjectivesList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "QuestionControlobjectivesList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "QuestionControlobjectivesView") {
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

        // Check field name 'num_ordre' first before field var 'x_num_ordre'
        $val = $CurrentForm->hasValue("num_ordre") ? $CurrentForm->getValue("num_ordre") : $CurrentForm->getValue("x_num_ordre");
        if (!$this->num_ordre->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->num_ordre->Visible = false; // Disable update for API request
            } else {
                $this->num_ordre->setFormValue($val);
            }
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

        // Check field name 'question_domain_id' first before field var 'x_question_domain_id'
        $val = $CurrentForm->hasValue("question_domain_id") ? $CurrentForm->getValue("question_domain_id") : $CurrentForm->getValue("x_question_domain_id");
        if (!$this->question_domain_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->question_domain_id->Visible = false; // Disable update for API request
            } else {
                $this->question_domain_id->setFormValue($val);
            }
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

        // Check field name 'function_csf' first before field var 'x_function_csf'
        $val = $CurrentForm->hasValue("function_csf") ? $CurrentForm->getValue("function_csf") : $CurrentForm->getValue("x_function_csf");
        if (!$this->function_csf->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->function_csf->Visible = false; // Disable update for API request
            } else {
                $this->function_csf->setFormValue($val);
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

        // Begin transaction
        if ($this->getCurrentDetailTable() != "") {
            $conn->beginTransaction();
        }

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

        // Add detail records
        if ($addRow) {
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("QuestionsLibraryGrid");
            if (in_array("questions_library", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->controlObj_id->setSessionValue($this->controlObj_name->CurrentValue); // Set master key
                $addRow = $detailPage->gridInsert();
                if (!$addRow) {
                $detailPage->controlObj_id->setSessionValue(""); // Clear master key if insert failed
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
            if ($masterTblVar == "question_domains") {
                $validMaster = true;
                $masterTbl = Container("question_domains");
                if (($parm = Get("fk_domain_name", Get("question_domain_id"))) !== null) {
                    $masterTbl->domain_name->setQueryStringValue($parm);
                    $this->question_domain_id->setQueryStringValue($masterTbl->domain_name->QueryStringValue);
                    $this->question_domain_id->setSessionValue($this->question_domain_id->QueryStringValue);
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "layers") {
                $validMaster = true;
                $masterTbl = Container("layers");
                if (($parm = Get("fk_name", Get("layer_id"))) !== null) {
                    $masterTbl->name->setQueryStringValue($parm);
                    $this->layer_id->setQueryStringValue($masterTbl->name->QueryStringValue);
                    $this->layer_id->setSessionValue($this->layer_id->QueryStringValue);
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "functions") {
                $validMaster = true;
                $masterTbl = Container("functions");
                if (($parm = Get("fk_id", Get("function_csf"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->function_csf->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->function_csf->setSessionValue($this->function_csf->QueryStringValue);
                    if (!is_numeric($masterTbl->id->QueryStringValue)) {
                        $validMaster = false;
                    }
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
            if ($masterTblVar == "question_domains") {
                $validMaster = true;
                $masterTbl = Container("question_domains");
                if (($parm = Post("fk_domain_name", Post("question_domain_id"))) !== null) {
                    $masterTbl->domain_name->setFormValue($parm);
                    $this->question_domain_id->setFormValue($masterTbl->domain_name->FormValue);
                    $this->question_domain_id->setSessionValue($this->question_domain_id->FormValue);
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "layers") {
                $validMaster = true;
                $masterTbl = Container("layers");
                if (($parm = Post("fk_name", Post("layer_id"))) !== null) {
                    $masterTbl->name->setFormValue($parm);
                    $this->layer_id->setFormValue($masterTbl->name->FormValue);
                    $this->layer_id->setSessionValue($this->layer_id->FormValue);
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "functions") {
                $validMaster = true;
                $masterTbl = Container("functions");
                if (($parm = Post("fk_id", Post("function_csf"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->function_csf->setFormValue($masterTbl->id->FormValue);
                    $this->function_csf->setSessionValue($this->function_csf->FormValue);
                    if (!is_numeric($masterTbl->id->FormValue)) {
                        $validMaster = false;
                    }
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
            if ($masterTblVar != "question_domains") {
                if ($this->question_domain_id->CurrentValue == "") {
                    $this->question_domain_id->setSessionValue("");
                }
            }
            if ($masterTblVar != "layers") {
                if ($this->layer_id->CurrentValue == "") {
                    $this->layer_id->setSessionValue("");
                }
            }
            if ($masterTblVar != "functions") {
                if ($this->function_csf->CurrentValue == "") {
                    $this->function_csf->setSessionValue("");
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
                    $detailPageObj->controlObj_id->IsDetailKey = true;
                    $detailPageObj->controlObj_id->CurrentValue = $this->controlObj_name->CurrentValue;
                    $detailPageObj->controlObj_id->setSessionValue($detailPageObj->controlObj_id->CurrentValue);
                    $detailPageObj->refs1->setSessionValue(""); // Clear session key
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("QuestionControlobjectivesList"), "", $this->TableVar, true);
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
}
