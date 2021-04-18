<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class RiskLibrairiesEdit extends RiskLibrairies
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'risk_librairies';

    // Page object name
    public $PageObjName = "RiskLibrairiesEdit";

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

        // Table object (risk_librairies)
        if (!isset($GLOBALS["risk_librairies"]) || get_class($GLOBALS["risk_librairies"]) == PROJECT_NAMESPACE . "risk_librairies") {
            $GLOBALS["risk_librairies"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'risk_librairies');
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
                $doc = new $class(Container("risk_librairies"));
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
                    if ($pageName == "RiskLibrairiesView") {
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
    public $FormClassName = "ew-horizontal ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

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
        $this->id->setVisibility();
        $this->title->setVisibility();
        $this->layer->setVisibility();
        $this->function_csf->setVisibility();
        $this->tag->setVisibility();
        $this->Confidentiality->setVisibility();
        $this->Integrity->setVisibility();
        $this->Availability->setVisibility();
        $this->Efficiency->setVisibility();
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
        $this->setupLookupOptions($this->layer);
        $this->setupLookupOptions($this->function_csf);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-edit-form ew-horizontal";

        // Load record by position
        $loadByPosition = false;
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("id") ?? Key(0) ?? Route(2)) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->id->setOldValue($this->id->QueryStringValue);
            } elseif (Post("id") !== null) {
                $this->id->setFormValue(Post("id"));
                $this->id->setOldValue($this->id->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("id") ?? Route("id")) !== null) {
                    $this->id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id->CurrentValue = null;
                }
                if (!$loadByQuery) {
                    $loadByPosition = true;
                }
            }

            // Set up master detail parameters
            $this->setupMasterParms();

            // Load recordset
            if ($this->isShow()) {
                $this->StartRecord = 1; // Initialize start position
                if ($rs = $this->loadRecordset()) { // Load records
                    $this->TotalRecords = $rs->recordCount(); // Get record count
                }
                if ($this->TotalRecords <= 0) { // No record found
                    if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                    }
                    $this->terminate("RiskLibrairiesList"); // Return to list page
                    return;
                } elseif ($loadByPosition) { // Load record by position
                    $this->setupStartRecord(); // Set up start record position
                    // Point to current record
                    if ($this->StartRecord <= $this->TotalRecords) {
                        $rs->move($this->StartRecord - 1);
                        $loaded = true;
                    }
                } else { // Match key values
                    if ($this->id->CurrentValue != null) {
                        while (!$rs->EOF) {
                            if (SameString($this->id->CurrentValue, $rs->fields['id'])) {
                                $this->setStartRecordNumber($this->StartRecord); // Save record position
                                $loaded = true;
                                break;
                            } else {
                                $this->StartRecord++;
                                $rs->moveNext();
                            }
                        }
                    }
                }

                // Load current row values
                if ($loaded) {
                    $this->loadRowValues($rs);
                }
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$loaded) {
                    if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                    }
                    $this->terminate("RiskLibrairiesList"); // Return to list page
                    return;
                } else {
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "RiskLibrairiesList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = ROWTYPE_EDIT; // Render as Edit
        $this->resetAttributes();
        $this->renderRow();
        $this->Pager = new PrevNextPager($this->StartRecord, $this->DisplayRecords, $this->TotalRecords, "", $this->RecordRange, $this->AutoHidePager);

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

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }

        // Check field name 'title' first before field var 'x_title'
        $val = $CurrentForm->hasValue("title") ? $CurrentForm->getValue("title") : $CurrentForm->getValue("x_title");
        if (!$this->title->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->title->Visible = false; // Disable update for API request
            } else {
                $this->title->setFormValue($val);
            }
        }

        // Check field name 'layer' first before field var 'x_layer'
        $val = $CurrentForm->hasValue("layer") ? $CurrentForm->getValue("layer") : $CurrentForm->getValue("x_layer");
        if (!$this->layer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->layer->Visible = false; // Disable update for API request
            } else {
                $this->layer->setFormValue($val);
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

        // Check field name 'tag' first before field var 'x_tag'
        $val = $CurrentForm->hasValue("tag") ? $CurrentForm->getValue("tag") : $CurrentForm->getValue("x_tag");
        if (!$this->tag->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tag->Visible = false; // Disable update for API request
            } else {
                $this->tag->setFormValue($val);
            }
        }

        // Check field name 'Confidentiality' first before field var 'x_Confidentiality'
        $val = $CurrentForm->hasValue("Confidentiality") ? $CurrentForm->getValue("Confidentiality") : $CurrentForm->getValue("x_Confidentiality");
        if (!$this->Confidentiality->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Confidentiality->Visible = false; // Disable update for API request
            } else {
                $this->Confidentiality->setFormValue($val);
            }
        }

        // Check field name 'Integrity' first before field var 'x_Integrity'
        $val = $CurrentForm->hasValue("Integrity") ? $CurrentForm->getValue("Integrity") : $CurrentForm->getValue("x_Integrity");
        if (!$this->Integrity->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Integrity->Visible = false; // Disable update for API request
            } else {
                $this->Integrity->setFormValue($val);
            }
        }

        // Check field name 'Availability' first before field var 'x_Availability'
        $val = $CurrentForm->hasValue("Availability") ? $CurrentForm->getValue("Availability") : $CurrentForm->getValue("x_Availability");
        if (!$this->Availability->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Availability->Visible = false; // Disable update for API request
            } else {
                $this->Availability->setFormValue($val);
            }
        }

        // Check field name 'Efficiency' first before field var 'x_Efficiency'
        $val = $CurrentForm->hasValue("Efficiency") ? $CurrentForm->getValue("Efficiency") : $CurrentForm->getValue("x_Efficiency");
        if (!$this->Efficiency->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Efficiency->Visible = false; // Disable update for API request
            } else {
                $this->Efficiency->setFormValue($val);
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
        $this->id->CurrentValue = $this->id->FormValue;
        $this->title->CurrentValue = $this->title->FormValue;
        $this->layer->CurrentValue = $this->layer->FormValue;
        $this->function_csf->CurrentValue = $this->function_csf->FormValue;
        $this->tag->CurrentValue = $this->tag->FormValue;
        $this->Confidentiality->CurrentValue = $this->Confidentiality->FormValue;
        $this->Integrity->CurrentValue = $this->Integrity->FormValue;
        $this->Availability->CurrentValue = $this->Availability->FormValue;
        $this->Efficiency->CurrentValue = $this->Efficiency->FormValue;
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
        $this->id->setDbValue($row['id']);
        $this->title->setDbValue($row['title']);
        $this->layer->setDbValue($row['layer']);
        $this->function_csf->setDbValue($row['function_csf']);
        $this->tag->setDbValue($row['tag']);
        $this->Confidentiality->setDbValue($row['Confidentiality']);
        $this->Integrity->setDbValue($row['Integrity']);
        $this->Availability->setDbValue($row['Availability']);
        $this->Efficiency->setDbValue($row['Efficiency']);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['title'] = null;
        $row['layer'] = null;
        $row['function_csf'] = null;
        $row['tag'] = null;
        $row['Confidentiality'] = null;
        $row['Integrity'] = null;
        $row['Availability'] = null;
        $row['Efficiency'] = null;
        $row['created_at'] = null;
        $row['updated_at'] = null;
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

        // title

        // layer

        // function_csf

        // tag

        // Confidentiality

        // Integrity

        // Availability

        // Efficiency

        // created_at

        // updated_at
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // title
            $this->title->ViewValue = $this->title->CurrentValue;
            $this->title->ViewCustomAttributes = "";

            // layer
            $this->layer->ViewValue = $this->layer->CurrentValue;
            $curVal = strval($this->layer->CurrentValue);
            if ($curVal != "") {
                $this->layer->ViewValue = $this->layer->lookupCacheOption($curVal);
                if ($this->layer->ViewValue === null) { // Lookup from database
                    $filterWrk = "`name`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->layer->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->layer->Lookup->renderViewRow($rswrk[0]);
                        $this->layer->ViewValue = $this->layer->displayValue($arwrk);
                    } else {
                        $this->layer->ViewValue = $this->layer->CurrentValue;
                    }
                }
            } else {
                $this->layer->ViewValue = null;
            }
            $this->layer->ViewCustomAttributes = "";

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

            // tag
            $this->tag->ViewValue = $this->tag->CurrentValue;
            $this->tag->ViewCustomAttributes = "";

            // Confidentiality
            if (strval($this->Confidentiality->CurrentValue) != "") {
                $this->Confidentiality->ViewValue = $this->Confidentiality->optionCaption($this->Confidentiality->CurrentValue);
            } else {
                $this->Confidentiality->ViewValue = null;
            }
            $this->Confidentiality->ViewCustomAttributes = "";

            // Integrity
            if (strval($this->Integrity->CurrentValue) != "") {
                $this->Integrity->ViewValue = $this->Integrity->optionCaption($this->Integrity->CurrentValue);
            } else {
                $this->Integrity->ViewValue = null;
            }
            $this->Integrity->ViewCustomAttributes = "";

            // Availability
            if (strval($this->Availability->CurrentValue) != "") {
                $this->Availability->ViewValue = $this->Availability->optionCaption($this->Availability->CurrentValue);
            } else {
                $this->Availability->ViewValue = null;
            }
            $this->Availability->ViewCustomAttributes = "";

            // Efficiency
            if (strval($this->Efficiency->CurrentValue) != "") {
                $this->Efficiency->ViewValue = $this->Efficiency->optionCaption($this->Efficiency->CurrentValue);
            } else {
                $this->Efficiency->ViewValue = null;
            }
            $this->Efficiency->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
            $this->updated_at->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // title
            $this->title->LinkCustomAttributes = "";
            $this->title->HrefValue = "";
            $this->title->TooltipValue = "";

            // layer
            $this->layer->LinkCustomAttributes = "";
            $this->layer->HrefValue = "";
            $this->layer->TooltipValue = "";

            // function_csf
            $this->function_csf->LinkCustomAttributes = "";
            $this->function_csf->HrefValue = "";
            $this->function_csf->TooltipValue = "";

            // tag
            $this->tag->LinkCustomAttributes = "";
            $this->tag->HrefValue = "";
            $this->tag->TooltipValue = "";

            // Confidentiality
            $this->Confidentiality->LinkCustomAttributes = "";
            $this->Confidentiality->HrefValue = "";
            $this->Confidentiality->TooltipValue = "";

            // Integrity
            $this->Integrity->LinkCustomAttributes = "";
            $this->Integrity->HrefValue = "";
            $this->Integrity->TooltipValue = "";

            // Availability
            $this->Availability->LinkCustomAttributes = "";
            $this->Availability->HrefValue = "";
            $this->Availability->TooltipValue = "";

            // Efficiency
            $this->Efficiency->LinkCustomAttributes = "";
            $this->Efficiency->HrefValue = "";
            $this->Efficiency->TooltipValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";
            $this->created_at->TooltipValue = "";

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";
            $this->updated_at->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->EditAttrs["class"] = "form-control";
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // title
            $this->title->EditAttrs["class"] = "form-control";
            $this->title->EditCustomAttributes = "";
            if (!$this->title->Raw) {
                $this->title->CurrentValue = HtmlDecode($this->title->CurrentValue);
            }
            $this->title->EditValue = HtmlEncode($this->title->CurrentValue);
            $this->title->PlaceHolder = RemoveHtml($this->title->caption());

            // layer
            $this->layer->EditAttrs["class"] = "form-control";
            $this->layer->EditCustomAttributes = "";
            if ($this->layer->getSessionValue() != "") {
                $this->layer->CurrentValue = GetForeignKeyValue($this->layer->getSessionValue());
                $this->layer->ViewValue = $this->layer->CurrentValue;
                $curVal = strval($this->layer->CurrentValue);
                if ($curVal != "") {
                    $this->layer->ViewValue = $this->layer->lookupCacheOption($curVal);
                    if ($this->layer->ViewValue === null) { // Lookup from database
                        $filterWrk = "`name`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                        $sqlWrk = $this->layer->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->layer->Lookup->renderViewRow($rswrk[0]);
                            $this->layer->ViewValue = $this->layer->displayValue($arwrk);
                        } else {
                            $this->layer->ViewValue = $this->layer->CurrentValue;
                        }
                    }
                } else {
                    $this->layer->ViewValue = null;
                }
                $this->layer->ViewCustomAttributes = "";
            } else {
                if (!$this->layer->Raw) {
                    $this->layer->CurrentValue = HtmlDecode($this->layer->CurrentValue);
                }
                $this->layer->EditValue = HtmlEncode($this->layer->CurrentValue);
                $curVal = strval($this->layer->CurrentValue);
                if ($curVal != "") {
                    $this->layer->EditValue = $this->layer->lookupCacheOption($curVal);
                    if ($this->layer->EditValue === null) { // Lookup from database
                        $filterWrk = "`name`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                        $sqlWrk = $this->layer->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->layer->Lookup->renderViewRow($rswrk[0]);
                            $this->layer->EditValue = $this->layer->displayValue($arwrk);
                        } else {
                            $this->layer->EditValue = HtmlEncode($this->layer->CurrentValue);
                        }
                    }
                } else {
                    $this->layer->EditValue = null;
                }
                $this->layer->PlaceHolder = RemoveHtml($this->layer->caption());
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

            // tag
            $this->tag->EditAttrs["class"] = "form-control";
            $this->tag->EditCustomAttributes = "";
            if (!$this->tag->Raw) {
                $this->tag->CurrentValue = HtmlDecode($this->tag->CurrentValue);
            }
            $this->tag->EditValue = HtmlEncode($this->tag->CurrentValue);
            $this->tag->PlaceHolder = RemoveHtml($this->tag->caption());

            // Confidentiality
            $this->Confidentiality->EditAttrs["class"] = "form-control";
            $this->Confidentiality->EditCustomAttributes = "";
            $this->Confidentiality->EditValue = $this->Confidentiality->options(true);
            $this->Confidentiality->PlaceHolder = RemoveHtml($this->Confidentiality->caption());

            // Integrity
            $this->Integrity->EditAttrs["class"] = "form-control";
            $this->Integrity->EditCustomAttributes = "";
            $this->Integrity->EditValue = $this->Integrity->options(true);
            $this->Integrity->PlaceHolder = RemoveHtml($this->Integrity->caption());

            // Availability
            $this->Availability->EditAttrs["class"] = "form-control";
            $this->Availability->EditCustomAttributes = "";
            $this->Availability->EditValue = $this->Availability->options(true);
            $this->Availability->PlaceHolder = RemoveHtml($this->Availability->caption());

            // Efficiency
            $this->Efficiency->EditAttrs["class"] = "form-control";
            $this->Efficiency->EditCustomAttributes = "";
            $this->Efficiency->EditValue = $this->Efficiency->options(true);
            $this->Efficiency->PlaceHolder = RemoveHtml($this->Efficiency->caption());

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

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // title
            $this->title->LinkCustomAttributes = "";
            $this->title->HrefValue = "";

            // layer
            $this->layer->LinkCustomAttributes = "";
            $this->layer->HrefValue = "";

            // function_csf
            $this->function_csf->LinkCustomAttributes = "";
            $this->function_csf->HrefValue = "";

            // tag
            $this->tag->LinkCustomAttributes = "";
            $this->tag->HrefValue = "";

            // Confidentiality
            $this->Confidentiality->LinkCustomAttributes = "";
            $this->Confidentiality->HrefValue = "";

            // Integrity
            $this->Integrity->LinkCustomAttributes = "";
            $this->Integrity->HrefValue = "";

            // Availability
            $this->Availability->LinkCustomAttributes = "";
            $this->Availability->HrefValue = "";

            // Efficiency
            $this->Efficiency->LinkCustomAttributes = "";
            $this->Efficiency->HrefValue = "";

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
        if ($this->id->Required) {
            if (!$this->id->IsDetailKey && EmptyValue($this->id->FormValue)) {
                $this->id->addErrorMessage(str_replace("%s", $this->id->caption(), $this->id->RequiredErrorMessage));
            }
        }
        if ($this->title->Required) {
            if (!$this->title->IsDetailKey && EmptyValue($this->title->FormValue)) {
                $this->title->addErrorMessage(str_replace("%s", $this->title->caption(), $this->title->RequiredErrorMessage));
            }
        }
        if ($this->layer->Required) {
            if (!$this->layer->IsDetailKey && EmptyValue($this->layer->FormValue)) {
                $this->layer->addErrorMessage(str_replace("%s", $this->layer->caption(), $this->layer->RequiredErrorMessage));
            }
        }
        if ($this->function_csf->Required) {
            if (!$this->function_csf->IsDetailKey && EmptyValue($this->function_csf->FormValue)) {
                $this->function_csf->addErrorMessage(str_replace("%s", $this->function_csf->caption(), $this->function_csf->RequiredErrorMessage));
            }
        }
        if ($this->tag->Required) {
            if (!$this->tag->IsDetailKey && EmptyValue($this->tag->FormValue)) {
                $this->tag->addErrorMessage(str_replace("%s", $this->tag->caption(), $this->tag->RequiredErrorMessage));
            }
        }
        if ($this->Confidentiality->Required) {
            if (!$this->Confidentiality->IsDetailKey && EmptyValue($this->Confidentiality->FormValue)) {
                $this->Confidentiality->addErrorMessage(str_replace("%s", $this->Confidentiality->caption(), $this->Confidentiality->RequiredErrorMessage));
            }
        }
        if ($this->Integrity->Required) {
            if (!$this->Integrity->IsDetailKey && EmptyValue($this->Integrity->FormValue)) {
                $this->Integrity->addErrorMessage(str_replace("%s", $this->Integrity->caption(), $this->Integrity->RequiredErrorMessage));
            }
        }
        if ($this->Availability->Required) {
            if (!$this->Availability->IsDetailKey && EmptyValue($this->Availability->FormValue)) {
                $this->Availability->addErrorMessage(str_replace("%s", $this->Availability->caption(), $this->Availability->RequiredErrorMessage));
            }
        }
        if ($this->Efficiency->Required) {
            if (!$this->Efficiency->IsDetailKey && EmptyValue($this->Efficiency->FormValue)) {
                $this->Efficiency->addErrorMessage(str_replace("%s", $this->Efficiency->caption(), $this->Efficiency->RequiredErrorMessage));
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

            // title
            $this->title->setDbValueDef($rsnew, $this->title->CurrentValue, "", $this->title->ReadOnly);

            // layer
            if ($this->layer->getSessionValue() != "") {
                $this->layer->ReadOnly = true;
            }
            $this->layer->setDbValueDef($rsnew, $this->layer->CurrentValue, "", $this->layer->ReadOnly);

            // function_csf
            if ($this->function_csf->getSessionValue() != "") {
                $this->function_csf->ReadOnly = true;
            }
            $this->function_csf->setDbValueDef($rsnew, $this->function_csf->CurrentValue, "", $this->function_csf->ReadOnly);

            // tag
            $this->tag->setDbValueDef($rsnew, $this->tag->CurrentValue, "", $this->tag->ReadOnly);

            // Confidentiality
            $this->Confidentiality->setDbValueDef($rsnew, $this->Confidentiality->CurrentValue, 0, $this->Confidentiality->ReadOnly);

            // Integrity
            $this->Integrity->setDbValueDef($rsnew, $this->Integrity->CurrentValue, 0, $this->Integrity->ReadOnly);

            // Availability
            $this->Availability->setDbValueDef($rsnew, $this->Availability->CurrentValue, 0, $this->Availability->ReadOnly);

            // Efficiency
            $this->Efficiency->setDbValueDef($rsnew, $this->Efficiency->CurrentValue, 0, $this->Efficiency->ReadOnly);

            // created_at
            $this->created_at->setDbValueDef($rsnew, UnFormatDateTime($this->created_at->CurrentValue, 0), null, $this->created_at->ReadOnly);

            // updated_at
            $this->updated_at->setDbValueDef($rsnew, UnFormatDateTime($this->updated_at->CurrentValue, 0), null, $this->updated_at->ReadOnly);

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);
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
            if ($masterTblVar == "layers") {
                $validMaster = true;
                $masterTbl = Container("layers");
                if (($parm = Get("fk_name", Get("layer"))) !== null) {
                    $masterTbl->name->setQueryStringValue($parm);
                    $this->layer->setQueryStringValue($masterTbl->name->QueryStringValue);
                    $this->layer->setSessionValue($this->layer->QueryStringValue);
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
            if ($masterTblVar == "layers") {
                $validMaster = true;
                $masterTbl = Container("layers");
                if (($parm = Post("fk_name", Post("layer"))) !== null) {
                    $masterTbl->name->setFormValue($parm);
                    $this->layer->setFormValue($masterTbl->name->FormValue);
                    $this->layer->setSessionValue($this->layer->FormValue);
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
            $this->setSessionWhere($this->getDetailFilter());

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "layers") {
                if ($this->layer->CurrentValue == "") {
                    $this->layer->setSessionValue("");
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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("RiskLibrairiesList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
                case "x_layer":
                    break;
                case "x_function_csf":
                    break;
                case "x_Confidentiality":
                    break;
                case "x_Integrity":
                    break;
                case "x_Availability":
                    break;
                case "x_Efficiency":
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

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        if ($this->isPageRequest()) { // Validate request
            $startRec = Get(Config("TABLE_START_REC"));
            $pageNo = Get(Config("TABLE_PAGE_NO"));
            if ($pageNo !== null) { // Check for "pageno" parameter first
                if (is_numeric($pageNo)) {
                    $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                    if ($this->StartRecord <= 0) {
                        $this->StartRecord = 1;
                    } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                        $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                    }
                    $this->setStartRecordNumber($this->StartRecord);
                }
            } elseif ($startRec !== null) { // Check for "start" parameter
                $this->StartRecord = $startRec;
                $this->setStartRecordNumber($this->StartRecord);
            }
        }
        $this->StartRecord = $this->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || $this->StartRecord == "") { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
            $this->setStartRecordNumber($this->StartRecord);
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
            $this->setStartRecordNumber($this->StartRecord);
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