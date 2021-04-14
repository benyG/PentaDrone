<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class Iso27001RefsAdd extends Iso27001Refs
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'iso27001_refs';

    // Page object name
    public $PageObjName = "Iso27001RefsAdd";

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

        // Table object (iso27001_refs)
        if (!isset($GLOBALS["iso27001_refs"]) || get_class($GLOBALS["iso27001_refs"]) == PROJECT_NAMESPACE . "iso27001_refs") {
            $GLOBALS["iso27001_refs"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'iso27001_refs');
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
                $doc = new $class(Container("iso27001_refs"));
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
                    if ($pageName == "Iso27001RefsView") {
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
            $key .= @$ar['code'];
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
        $this->code->setVisibility();
        $this->control_familyName_id->setVisibility();
        $this->control_name->setVisibility();
        $this->description->setVisibility();
        $this->control_ID->setVisibility();
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
        $this->setupLookupOptions($this->control_familyName_id);

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
            if (($keyValue = Get("code") ?? Route("code")) !== null) {
                $this->code->setQueryStringValue($keyValue);
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
                    $this->terminate("Iso27001RefsList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "Iso27001RefsList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "Iso27001RefsView") {
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
        $this->code->CurrentValue = null;
        $this->code->OldValue = $this->code->CurrentValue;
        $this->control_familyName_id->CurrentValue = null;
        $this->control_familyName_id->OldValue = $this->control_familyName_id->CurrentValue;
        $this->control_name->CurrentValue = null;
        $this->control_name->OldValue = $this->control_name->CurrentValue;
        $this->description->CurrentValue = null;
        $this->description->OldValue = $this->description->CurrentValue;
        $this->control_ID->CurrentValue = null;
        $this->control_ID->OldValue = $this->control_ID->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'code' first before field var 'x_code'
        $val = $CurrentForm->hasValue("code") ? $CurrentForm->getValue("code") : $CurrentForm->getValue("x_code");
        if (!$this->code->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->code->Visible = false; // Disable update for API request
            } else {
                $this->code->setFormValue($val);
            }
        }

        // Check field name 'control_familyName_id' first before field var 'x_control_familyName_id'
        $val = $CurrentForm->hasValue("control_familyName_id") ? $CurrentForm->getValue("control_familyName_id") : $CurrentForm->getValue("x_control_familyName_id");
        if (!$this->control_familyName_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->control_familyName_id->Visible = false; // Disable update for API request
            } else {
                $this->control_familyName_id->setFormValue($val);
            }
        }

        // Check field name 'control_name' first before field var 'x_control_name'
        $val = $CurrentForm->hasValue("control_name") ? $CurrentForm->getValue("control_name") : $CurrentForm->getValue("x_control_name");
        if (!$this->control_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->control_name->Visible = false; // Disable update for API request
            } else {
                $this->control_name->setFormValue($val);
            }
        }

        // Check field name 'description' first before field var 'x_description'
        $val = $CurrentForm->hasValue("description") ? $CurrentForm->getValue("description") : $CurrentForm->getValue("x_description");
        if (!$this->description->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->description->Visible = false; // Disable update for API request
            } else {
                $this->description->setFormValue($val);
            }
        }

        // Check field name 'control_ID' first before field var 'x_control_ID'
        $val = $CurrentForm->hasValue("control_ID") ? $CurrentForm->getValue("control_ID") : $CurrentForm->getValue("x_control_ID");
        if (!$this->control_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->control_ID->Visible = false; // Disable update for API request
            } else {
                $this->control_ID->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->code->CurrentValue = $this->code->FormValue;
        $this->control_familyName_id->CurrentValue = $this->control_familyName_id->FormValue;
        $this->control_name->CurrentValue = $this->control_name->FormValue;
        $this->description->CurrentValue = $this->description->FormValue;
        $this->control_ID->CurrentValue = $this->control_ID->FormValue;
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
        $this->code->setDbValue($row['code']);
        $this->control_familyName_id->setDbValue($row['control_familyName_id']);
        $this->control_name->setDbValue($row['control_name']);
        $this->description->setDbValue($row['description']);
        $this->control_ID->setDbValue($row['control_ID']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['code'] = $this->code->CurrentValue;
        $row['control_familyName_id'] = $this->control_familyName_id->CurrentValue;
        $row['control_name'] = $this->control_name->CurrentValue;
        $row['description'] = $this->description->CurrentValue;
        $row['control_ID'] = $this->control_ID->CurrentValue;
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

        // code

        // control_familyName_id

        // control_name

        // description

        // control_ID
        if ($this->RowType == ROWTYPE_VIEW) {
            // code
            $this->code->ViewValue = $this->code->CurrentValue;
            $this->code->ViewCustomAttributes = "";

            // control_familyName_id
            $curVal = strval($this->control_familyName_id->CurrentValue);
            if ($curVal != "") {
                $this->control_familyName_id->ViewValue = $this->control_familyName_id->lookupCacheOption($curVal);
                if ($this->control_familyName_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "`control_familyName`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->control_familyName_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->control_familyName_id->Lookup->renderViewRow($rswrk[0]);
                        $this->control_familyName_id->ViewValue = $this->control_familyName_id->displayValue($arwrk);
                    } else {
                        $this->control_familyName_id->ViewValue = $this->control_familyName_id->CurrentValue;
                    }
                }
            } else {
                $this->control_familyName_id->ViewValue = null;
            }
            $this->control_familyName_id->ViewCustomAttributes = "";

            // control_name
            $this->control_name->ViewValue = $this->control_name->CurrentValue;
            $this->control_name->ViewCustomAttributes = "";

            // description
            $this->description->ViewValue = $this->description->CurrentValue;
            $this->description->ViewCustomAttributes = "";

            // control_ID
            $this->control_ID->ViewValue = $this->control_ID->CurrentValue;
            $this->control_ID->ViewCustomAttributes = "";

            // code
            $this->code->LinkCustomAttributes = "";
            $this->code->HrefValue = "";
            $this->code->TooltipValue = "";

            // control_familyName_id
            $this->control_familyName_id->LinkCustomAttributes = "";
            $this->control_familyName_id->HrefValue = "";
            $this->control_familyName_id->TooltipValue = "";

            // control_name
            $this->control_name->LinkCustomAttributes = "";
            $this->control_name->HrefValue = "";
            $this->control_name->TooltipValue = "";

            // description
            $this->description->LinkCustomAttributes = "";
            $this->description->HrefValue = "";
            $this->description->TooltipValue = "";

            // control_ID
            $this->control_ID->LinkCustomAttributes = "";
            $this->control_ID->HrefValue = "";
            $this->control_ID->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // code
            $this->code->EditAttrs["class"] = "form-control";
            $this->code->EditCustomAttributes = "";
            if (!$this->code->Raw) {
                $this->code->CurrentValue = HtmlDecode($this->code->CurrentValue);
            }
            $this->code->EditValue = HtmlEncode($this->code->CurrentValue);
            $this->code->PlaceHolder = RemoveHtml($this->code->caption());

            // control_familyName_id
            $this->control_familyName_id->EditAttrs["class"] = "form-control";
            $this->control_familyName_id->EditCustomAttributes = "";
            if ($this->control_familyName_id->getSessionValue() != "") {
                $this->control_familyName_id->CurrentValue = GetForeignKeyValue($this->control_familyName_id->getSessionValue());
                $curVal = strval($this->control_familyName_id->CurrentValue);
                if ($curVal != "") {
                    $this->control_familyName_id->ViewValue = $this->control_familyName_id->lookupCacheOption($curVal);
                    if ($this->control_familyName_id->ViewValue === null) { // Lookup from database
                        $filterWrk = "`control_familyName`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                        $sqlWrk = $this->control_familyName_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->control_familyName_id->Lookup->renderViewRow($rswrk[0]);
                            $this->control_familyName_id->ViewValue = $this->control_familyName_id->displayValue($arwrk);
                        } else {
                            $this->control_familyName_id->ViewValue = $this->control_familyName_id->CurrentValue;
                        }
                    }
                } else {
                    $this->control_familyName_id->ViewValue = null;
                }
                $this->control_familyName_id->ViewCustomAttributes = "";
            } else {
                $curVal = trim(strval($this->control_familyName_id->CurrentValue));
                if ($curVal != "") {
                    $this->control_familyName_id->ViewValue = $this->control_familyName_id->lookupCacheOption($curVal);
                } else {
                    $this->control_familyName_id->ViewValue = $this->control_familyName_id->Lookup !== null && is_array($this->control_familyName_id->Lookup->Options) ? $curVal : null;
                }
                if ($this->control_familyName_id->ViewValue !== null) { // Load from cache
                    $this->control_familyName_id->EditValue = array_values($this->control_familyName_id->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`control_familyName`" . SearchString("=", $this->control_familyName_id->CurrentValue, DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->control_familyName_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->control_familyName_id->EditValue = $arwrk;
                }
                $this->control_familyName_id->PlaceHolder = RemoveHtml($this->control_familyName_id->caption());
            }

            // control_name
            $this->control_name->EditAttrs["class"] = "form-control";
            $this->control_name->EditCustomAttributes = "";
            if (!$this->control_name->Raw) {
                $this->control_name->CurrentValue = HtmlDecode($this->control_name->CurrentValue);
            }
            $this->control_name->EditValue = HtmlEncode($this->control_name->CurrentValue);
            $this->control_name->PlaceHolder = RemoveHtml($this->control_name->caption());

            // description
            $this->description->EditAttrs["class"] = "form-control";
            $this->description->EditCustomAttributes = "";
            $this->description->EditValue = HtmlEncode($this->description->CurrentValue);
            $this->description->PlaceHolder = RemoveHtml($this->description->caption());

            // control_ID
            $this->control_ID->EditAttrs["class"] = "form-control";
            $this->control_ID->EditCustomAttributes = "";
            if (!$this->control_ID->Raw) {
                $this->control_ID->CurrentValue = HtmlDecode($this->control_ID->CurrentValue);
            }
            $this->control_ID->EditValue = HtmlEncode($this->control_ID->CurrentValue);
            $this->control_ID->PlaceHolder = RemoveHtml($this->control_ID->caption());

            // Add refer script

            // code
            $this->code->LinkCustomAttributes = "";
            $this->code->HrefValue = "";

            // control_familyName_id
            $this->control_familyName_id->LinkCustomAttributes = "";
            $this->control_familyName_id->HrefValue = "";

            // control_name
            $this->control_name->LinkCustomAttributes = "";
            $this->control_name->HrefValue = "";

            // description
            $this->description->LinkCustomAttributes = "";
            $this->description->HrefValue = "";

            // control_ID
            $this->control_ID->LinkCustomAttributes = "";
            $this->control_ID->HrefValue = "";
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
        if ($this->code->Required) {
            if (!$this->code->IsDetailKey && EmptyValue($this->code->FormValue)) {
                $this->code->addErrorMessage(str_replace("%s", $this->code->caption(), $this->code->RequiredErrorMessage));
            }
        }
        if ($this->control_familyName_id->Required) {
            if (!$this->control_familyName_id->IsDetailKey && EmptyValue($this->control_familyName_id->FormValue)) {
                $this->control_familyName_id->addErrorMessage(str_replace("%s", $this->control_familyName_id->caption(), $this->control_familyName_id->RequiredErrorMessage));
            }
        }
        if ($this->control_name->Required) {
            if (!$this->control_name->IsDetailKey && EmptyValue($this->control_name->FormValue)) {
                $this->control_name->addErrorMessage(str_replace("%s", $this->control_name->caption(), $this->control_name->RequiredErrorMessage));
            }
        }
        if ($this->description->Required) {
            if (!$this->description->IsDetailKey && EmptyValue($this->description->FormValue)) {
                $this->description->addErrorMessage(str_replace("%s", $this->description->caption(), $this->description->RequiredErrorMessage));
            }
        }
        if ($this->control_ID->Required) {
            if (!$this->control_ID->IsDetailKey && EmptyValue($this->control_ID->FormValue)) {
                $this->control_ID->addErrorMessage(str_replace("%s", $this->control_ID->caption(), $this->control_ID->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("SubcatIso27001LinksGrid");
        if (in_array("subcat_iso27001_links", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("QuestionsLibraryGrid");
        if (in_array("questions_library", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("NistToIso27001Grid");
        if (in_array("nist_to_iso27001", $detailTblVar) && $detailPage->DetailAdd) {
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

        // code
        $this->code->setDbValueDef($rsnew, $this->code->CurrentValue, "", false);

        // control_familyName_id
        $this->control_familyName_id->setDbValueDef($rsnew, $this->control_familyName_id->CurrentValue, "", false);

        // control_name
        $this->control_name->setDbValueDef($rsnew, $this->control_name->CurrentValue, "", false);

        // description
        $this->description->setDbValueDef($rsnew, $this->description->CurrentValue, "", false);

        // control_ID
        $this->control_ID->setDbValueDef($rsnew, $this->control_ID->CurrentValue, "", false);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['code']) == "") {
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
            $detailPage = Container("SubcatIso27001LinksGrid");
            if (in_array("subcat_iso27001_links", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->iso27001_code->setSessionValue($this->code->CurrentValue); // Set master key
                $addRow = $detailPage->gridInsert();
                if (!$addRow) {
                $detailPage->iso27001_code->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("QuestionsLibraryGrid");
            if (in_array("questions_library", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->refs1->setSessionValue($this->code->CurrentValue); // Set master key
                $addRow = $detailPage->gridInsert();
                if (!$addRow) {
                $detailPage->refs1->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("NistToIso27001Grid");
            if (in_array("nist_to_iso27001", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->isorefs->setSessionValue($this->control_ID->CurrentValue); // Set master key
                $addRow = $detailPage->gridInsert();
                if (!$addRow) {
                $detailPage->isorefs->setSessionValue(""); // Clear master key if insert failed
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
            if ($masterTblVar == "iso27001_family") {
                $validMaster = true;
                $masterTbl = Container("iso27001_family");
                if (($parm = Get("fk_control_familyName", Get("control_familyName_id"))) !== null) {
                    $masterTbl->control_familyName->setQueryStringValue($parm);
                    $this->control_familyName_id->setQueryStringValue($masterTbl->control_familyName->QueryStringValue);
                    $this->control_familyName_id->setSessionValue($this->control_familyName_id->QueryStringValue);
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
            if ($masterTblVar == "iso27001_family") {
                $validMaster = true;
                $masterTbl = Container("iso27001_family");
                if (($parm = Post("fk_control_familyName", Post("control_familyName_id"))) !== null) {
                    $masterTbl->control_familyName->setFormValue($parm);
                    $this->control_familyName_id->setFormValue($masterTbl->control_familyName->FormValue);
                    $this->control_familyName_id->setSessionValue($this->control_familyName_id->FormValue);
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
            if ($masterTblVar != "iso27001_family") {
                if ($this->control_familyName_id->CurrentValue == "") {
                    $this->control_familyName_id->setSessionValue("");
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
            if (in_array("subcat_iso27001_links", $detailTblVar)) {
                $detailPageObj = Container("SubcatIso27001LinksGrid");
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
                    $detailPageObj->iso27001_code->IsDetailKey = true;
                    $detailPageObj->iso27001_code->CurrentValue = $this->code->CurrentValue;
                    $detailPageObj->iso27001_code->setSessionValue($detailPageObj->iso27001_code->CurrentValue);
                    $detailPageObj->subcat_id->setSessionValue(""); // Clear session key
                }
            }
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
                    $detailPageObj->refs1->CurrentValue = $this->code->CurrentValue;
                    $detailPageObj->refs1->setSessionValue($detailPageObj->refs1->CurrentValue);
                    $detailPageObj->controlObj_id->setSessionValue(""); // Clear session key
                }
            }
            if (in_array("nist_to_iso27001", $detailTblVar)) {
                $detailPageObj = Container("NistToIso27001Grid");
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
                    $detailPageObj->isorefs->IsDetailKey = true;
                    $detailPageObj->isorefs->CurrentValue = $this->control_ID->CurrentValue;
                    $detailPageObj->isorefs->setSessionValue($detailPageObj->isorefs->CurrentValue);
                    $detailPageObj->nistrefs_family->setSessionValue(""); // Clear session key
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("Iso27001RefsList"), "", $this->TableVar, true);
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
                case "x_control_familyName_id":
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
