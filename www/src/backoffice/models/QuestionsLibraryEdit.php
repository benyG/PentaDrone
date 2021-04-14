<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class QuestionsLibraryEdit extends QuestionsLibrary
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'questions_library';

    // Page object name
    public $PageObjName = "QuestionsLibraryEdit";

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

        // Table object (questions_library)
        if (!isset($GLOBALS["questions_library"]) || get_class($GLOBALS["questions_library"]) == PROJECT_NAMESPACE . "questions_library") {
            $GLOBALS["questions_library"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'questions_library');
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
                $doc = new $class(Container("questions_library"));
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
                    if ($pageName == "QuestionsLibraryView") {
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
        $this->libelle->setVisibility();
        $this->Evidence_to_request->setVisibility();
        $this->controlObj_id->setVisibility();
        $this->created_at->setVisibility();
        $this->updated_at->setVisibility();
        $this->refs1->setVisibility();
        $this->refs2->setVisibility();
        $this->Activation_status->setVisibility();
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
        $this->setupLookupOptions($this->controlObj_id);

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
                    $this->terminate("QuestionsLibraryList"); // Return to list page
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
                    $this->terminate("QuestionsLibraryList"); // Return to list page
                    return;
                } else {
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "QuestionsLibraryList") {
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

        // Check field name 'libelle' first before field var 'x_libelle'
        $val = $CurrentForm->hasValue("libelle") ? $CurrentForm->getValue("libelle") : $CurrentForm->getValue("x_libelle");
        if (!$this->libelle->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->libelle->Visible = false; // Disable update for API request
            } else {
                $this->libelle->setFormValue($val);
            }
        }

        // Check field name 'Evidence_to_request' first before field var 'x_Evidence_to_request'
        $val = $CurrentForm->hasValue("Evidence_to_request") ? $CurrentForm->getValue("Evidence_to_request") : $CurrentForm->getValue("x_Evidence_to_request");
        if (!$this->Evidence_to_request->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Evidence_to_request->Visible = false; // Disable update for API request
            } else {
                $this->Evidence_to_request->setFormValue($val);
            }
        }

        // Check field name 'controlObj_id' first before field var 'x_controlObj_id'
        $val = $CurrentForm->hasValue("controlObj_id") ? $CurrentForm->getValue("controlObj_id") : $CurrentForm->getValue("x_controlObj_id");
        if (!$this->controlObj_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->controlObj_id->Visible = false; // Disable update for API request
            } else {
                $this->controlObj_id->setFormValue($val);
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

        // Check field name 'refs1' first before field var 'x_refs1'
        $val = $CurrentForm->hasValue("refs1") ? $CurrentForm->getValue("refs1") : $CurrentForm->getValue("x_refs1");
        if (!$this->refs1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->refs1->Visible = false; // Disable update for API request
            } else {
                $this->refs1->setFormValue($val);
            }
        }

        // Check field name 'refs2' first before field var 'x_refs2'
        $val = $CurrentForm->hasValue("refs2") ? $CurrentForm->getValue("refs2") : $CurrentForm->getValue("x_refs2");
        if (!$this->refs2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->refs2->Visible = false; // Disable update for API request
            } else {
                $this->refs2->setFormValue($val);
            }
        }

        // Check field name 'Activation_status' first before field var 'x_Activation_status'
        $val = $CurrentForm->hasValue("Activation_status") ? $CurrentForm->getValue("Activation_status") : $CurrentForm->getValue("x_Activation_status");
        if (!$this->Activation_status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Activation_status->Visible = false; // Disable update for API request
            } else {
                $this->Activation_status->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->libelle->CurrentValue = $this->libelle->FormValue;
        $this->Evidence_to_request->CurrentValue = $this->Evidence_to_request->FormValue;
        $this->controlObj_id->CurrentValue = $this->controlObj_id->FormValue;
        $this->created_at->CurrentValue = $this->created_at->FormValue;
        $this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, 0);
        $this->updated_at->CurrentValue = $this->updated_at->FormValue;
        $this->updated_at->CurrentValue = UnFormatDateTime($this->updated_at->CurrentValue, 0);
        $this->refs1->CurrentValue = $this->refs1->FormValue;
        $this->refs2->CurrentValue = $this->refs2->FormValue;
        $this->Activation_status->CurrentValue = $this->Activation_status->FormValue;
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
        $this->libelle->setDbValue($row['libelle']);
        $this->Evidence_to_request->setDbValue($row['Evidence_to_request']);
        $this->controlObj_id->setDbValue($row['controlObj_id']);
        if (array_key_exists('EV__controlObj_id', $row)) {
            $this->controlObj_id->VirtualValue = $row['EV__controlObj_id']; // Set up virtual field value
        } else {
            $this->controlObj_id->VirtualValue = ""; // Clear value
        }
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
        $this->refs1->setDbValue($row['refs1']);
        $this->refs2->setDbValue($row['refs2']);
        $this->Activation_status->setDbValue($row['Activation_status']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['libelle'] = null;
        $row['Evidence_to_request'] = null;
        $row['controlObj_id'] = null;
        $row['created_at'] = null;
        $row['updated_at'] = null;
        $row['refs1'] = null;
        $row['refs2'] = null;
        $row['Activation_status'] = null;
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

        // libelle

        // Evidence_to_request

        // controlObj_id

        // created_at

        // updated_at

        // refs1

        // refs2

        // Activation_status
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // libelle
            $this->libelle->ViewValue = $this->libelle->CurrentValue;
            $this->libelle->ViewCustomAttributes = "";

            // Evidence_to_request
            $this->Evidence_to_request->ViewValue = $this->Evidence_to_request->CurrentValue;
            $this->Evidence_to_request->ViewCustomAttributes = "";

            // controlObj_id
            if ($this->controlObj_id->VirtualValue != "") {
                $this->controlObj_id->ViewValue = $this->controlObj_id->VirtualValue;
            } else {
                $curVal = strval($this->controlObj_id->CurrentValue);
                if ($curVal != "") {
                    $this->controlObj_id->ViewValue = $this->controlObj_id->lookupCacheOption($curVal);
                    if ($this->controlObj_id->ViewValue === null) { // Lookup from database
                        $filterWrk = "`controlObj_name`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                        $sqlWrk = $this->controlObj_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->controlObj_id->Lookup->renderViewRow($rswrk[0]);
                            $this->controlObj_id->ViewValue = $this->controlObj_id->displayValue($arwrk);
                        } else {
                            $this->controlObj_id->ViewValue = $this->controlObj_id->CurrentValue;
                        }
                    }
                } else {
                    $this->controlObj_id->ViewValue = null;
                }
            }
            $this->controlObj_id->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
            $this->updated_at->ViewCustomAttributes = "";

            // refs1
            $this->refs1->ViewValue = $this->refs1->CurrentValue;
            $this->refs1->ViewCustomAttributes = "";

            // refs2
            $this->refs2->ViewValue = $this->refs2->CurrentValue;
            $this->refs2->ViewCustomAttributes = "";

            // Activation_status
            $this->Activation_status->ViewValue = $this->Activation_status->CurrentValue;
            $this->Activation_status->ViewValue = FormatNumber($this->Activation_status->ViewValue, 0, -2, -2, -2);
            $this->Activation_status->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // libelle
            $this->libelle->LinkCustomAttributes = "";
            $this->libelle->HrefValue = "";
            $this->libelle->TooltipValue = "";

            // Evidence_to_request
            $this->Evidence_to_request->LinkCustomAttributes = "";
            $this->Evidence_to_request->HrefValue = "";
            $this->Evidence_to_request->TooltipValue = "";

            // controlObj_id
            $this->controlObj_id->LinkCustomAttributes = "";
            $this->controlObj_id->HrefValue = "";
            $this->controlObj_id->TooltipValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";
            $this->created_at->TooltipValue = "";

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";
            $this->updated_at->TooltipValue = "";

            // refs1
            $this->refs1->LinkCustomAttributes = "";
            $this->refs1->HrefValue = "";
            $this->refs1->TooltipValue = "";

            // refs2
            $this->refs2->LinkCustomAttributes = "";
            $this->refs2->HrefValue = "";
            $this->refs2->TooltipValue = "";

            // Activation_status
            $this->Activation_status->LinkCustomAttributes = "";
            $this->Activation_status->HrefValue = "";
            $this->Activation_status->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->EditAttrs["class"] = "form-control";
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // libelle
            $this->libelle->EditAttrs["class"] = "form-control";
            $this->libelle->EditCustomAttributes = "";
            if (!$this->libelle->Raw) {
                $this->libelle->CurrentValue = HtmlDecode($this->libelle->CurrentValue);
            }
            $this->libelle->EditValue = HtmlEncode($this->libelle->CurrentValue);
            $this->libelle->PlaceHolder = RemoveHtml($this->libelle->caption());

            // Evidence_to_request
            $this->Evidence_to_request->EditAttrs["class"] = "form-control";
            $this->Evidence_to_request->EditCustomAttributes = "";
            $this->Evidence_to_request->EditValue = HtmlEncode($this->Evidence_to_request->CurrentValue);
            $this->Evidence_to_request->PlaceHolder = RemoveHtml($this->Evidence_to_request->caption());

            // controlObj_id
            $this->controlObj_id->EditAttrs["class"] = "form-control";
            $this->controlObj_id->EditCustomAttributes = "";
            if ($this->controlObj_id->getSessionValue() != "") {
                $this->controlObj_id->CurrentValue = GetForeignKeyValue($this->controlObj_id->getSessionValue());
                if ($this->controlObj_id->VirtualValue != "") {
                    $this->controlObj_id->ViewValue = $this->controlObj_id->VirtualValue;
                } else {
                    $curVal = strval($this->controlObj_id->CurrentValue);
                    if ($curVal != "") {
                        $this->controlObj_id->ViewValue = $this->controlObj_id->lookupCacheOption($curVal);
                        if ($this->controlObj_id->ViewValue === null) { // Lookup from database
                            $filterWrk = "`controlObj_name`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                            $sqlWrk = $this->controlObj_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                            $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                            $ari = count($rswrk);
                            if ($ari > 0) { // Lookup values found
                                $arwrk = $this->controlObj_id->Lookup->renderViewRow($rswrk[0]);
                                $this->controlObj_id->ViewValue = $this->controlObj_id->displayValue($arwrk);
                            } else {
                                $this->controlObj_id->ViewValue = $this->controlObj_id->CurrentValue;
                            }
                        }
                    } else {
                        $this->controlObj_id->ViewValue = null;
                    }
                }
                $this->controlObj_id->ViewCustomAttributes = "";
            } else {
                $curVal = trim(strval($this->controlObj_id->CurrentValue));
                if ($curVal != "") {
                    $this->controlObj_id->ViewValue = $this->controlObj_id->lookupCacheOption($curVal);
                } else {
                    $this->controlObj_id->ViewValue = $this->controlObj_id->Lookup !== null && is_array($this->controlObj_id->Lookup->Options) ? $curVal : null;
                }
                if ($this->controlObj_id->ViewValue !== null) { // Load from cache
                    $this->controlObj_id->EditValue = array_values($this->controlObj_id->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`controlObj_name`" . SearchString("=", $this->controlObj_id->CurrentValue, DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->controlObj_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->controlObj_id->EditValue = $arwrk;
                }
                $this->controlObj_id->PlaceHolder = RemoveHtml($this->controlObj_id->caption());
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

            // refs1
            $this->refs1->EditAttrs["class"] = "form-control";
            $this->refs1->EditCustomAttributes = "";
            if ($this->refs1->getSessionValue() != "") {
                $this->refs1->CurrentValue = GetForeignKeyValue($this->refs1->getSessionValue());
                $this->refs1->ViewValue = $this->refs1->CurrentValue;
                $this->refs1->ViewCustomAttributes = "";
            } else {
                if (!$this->refs1->Raw) {
                    $this->refs1->CurrentValue = HtmlDecode($this->refs1->CurrentValue);
                }
                $this->refs1->EditValue = HtmlEncode($this->refs1->CurrentValue);
                $this->refs1->PlaceHolder = RemoveHtml($this->refs1->caption());
            }

            // refs2
            $this->refs2->EditAttrs["class"] = "form-control";
            $this->refs2->EditCustomAttributes = "";
            if (!$this->refs2->Raw) {
                $this->refs2->CurrentValue = HtmlDecode($this->refs2->CurrentValue);
            }
            $this->refs2->EditValue = HtmlEncode($this->refs2->CurrentValue);
            $this->refs2->PlaceHolder = RemoveHtml($this->refs2->caption());

            // Activation_status
            $this->Activation_status->EditAttrs["class"] = "form-control";
            $this->Activation_status->EditCustomAttributes = "";
            $this->Activation_status->EditValue = HtmlEncode($this->Activation_status->CurrentValue);
            $this->Activation_status->PlaceHolder = RemoveHtml($this->Activation_status->caption());

            // Edit refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // libelle
            $this->libelle->LinkCustomAttributes = "";
            $this->libelle->HrefValue = "";

            // Evidence_to_request
            $this->Evidence_to_request->LinkCustomAttributes = "";
            $this->Evidence_to_request->HrefValue = "";

            // controlObj_id
            $this->controlObj_id->LinkCustomAttributes = "";
            $this->controlObj_id->HrefValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";

            // refs1
            $this->refs1->LinkCustomAttributes = "";
            $this->refs1->HrefValue = "";

            // refs2
            $this->refs2->LinkCustomAttributes = "";
            $this->refs2->HrefValue = "";

            // Activation_status
            $this->Activation_status->LinkCustomAttributes = "";
            $this->Activation_status->HrefValue = "";
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
        if ($this->libelle->Required) {
            if (!$this->libelle->IsDetailKey && EmptyValue($this->libelle->FormValue)) {
                $this->libelle->addErrorMessage(str_replace("%s", $this->libelle->caption(), $this->libelle->RequiredErrorMessage));
            }
        }
        if ($this->Evidence_to_request->Required) {
            if (!$this->Evidence_to_request->IsDetailKey && EmptyValue($this->Evidence_to_request->FormValue)) {
                $this->Evidence_to_request->addErrorMessage(str_replace("%s", $this->Evidence_to_request->caption(), $this->Evidence_to_request->RequiredErrorMessage));
            }
        }
        if ($this->controlObj_id->Required) {
            if (!$this->controlObj_id->IsDetailKey && EmptyValue($this->controlObj_id->FormValue)) {
                $this->controlObj_id->addErrorMessage(str_replace("%s", $this->controlObj_id->caption(), $this->controlObj_id->RequiredErrorMessage));
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
        if ($this->refs1->Required) {
            if (!$this->refs1->IsDetailKey && EmptyValue($this->refs1->FormValue)) {
                $this->refs1->addErrorMessage(str_replace("%s", $this->refs1->caption(), $this->refs1->RequiredErrorMessage));
            }
        }
        if ($this->refs2->Required) {
            if (!$this->refs2->IsDetailKey && EmptyValue($this->refs2->FormValue)) {
                $this->refs2->addErrorMessage(str_replace("%s", $this->refs2->caption(), $this->refs2->RequiredErrorMessage));
            }
        }
        if ($this->Activation_status->Required) {
            if (!$this->Activation_status->IsDetailKey && EmptyValue($this->Activation_status->FormValue)) {
                $this->Activation_status->addErrorMessage(str_replace("%s", $this->Activation_status->caption(), $this->Activation_status->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->Activation_status->FormValue)) {
            $this->Activation_status->addErrorMessage($this->Activation_status->getErrorMessage(false));
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

            // libelle
            $this->libelle->setDbValueDef($rsnew, $this->libelle->CurrentValue, "", $this->libelle->ReadOnly);

            // Evidence_to_request
            $this->Evidence_to_request->setDbValueDef($rsnew, $this->Evidence_to_request->CurrentValue, "", $this->Evidence_to_request->ReadOnly);

            // controlObj_id
            if ($this->controlObj_id->getSessionValue() != "") {
                $this->controlObj_id->ReadOnly = true;
            }
            $this->controlObj_id->setDbValueDef($rsnew, $this->controlObj_id->CurrentValue, "", $this->controlObj_id->ReadOnly);

            // created_at
            $this->created_at->setDbValueDef($rsnew, UnFormatDateTime($this->created_at->CurrentValue, 0), null, $this->created_at->ReadOnly);

            // updated_at
            $this->updated_at->setDbValueDef($rsnew, UnFormatDateTime($this->updated_at->CurrentValue, 0), null, $this->updated_at->ReadOnly);

            // refs1
            if ($this->refs1->getSessionValue() != "") {
                $this->refs1->ReadOnly = true;
            }
            $this->refs1->setDbValueDef($rsnew, $this->refs1->CurrentValue, "", $this->refs1->ReadOnly);

            // refs2
            $this->refs2->setDbValueDef($rsnew, $this->refs2->CurrentValue, "", $this->refs2->ReadOnly);

            // Activation_status
            $this->Activation_status->setDbValueDef($rsnew, $this->Activation_status->CurrentValue, 0, $this->Activation_status->ReadOnly);

            // Check referential integrity for master table 'question_controlobjectives'
            $validMasterRecord = true;
            $masterFilter = $this->sqlMasterFilter_question_controlobjectives();
            $keyValue = $rsnew['controlObj_id'] ?? $rsold['controlObj_id'];
            if (strval($keyValue) != "") {
                $masterFilter = str_replace("@controlObj_name@", AdjustSql($keyValue), $masterFilter);
            } else {
                $validMasterRecord = false;
            }
            if ($validMasterRecord) {
                $rsmaster = Container("question_controlobjectives")->loadRs($masterFilter)->fetch();
                $validMasterRecord = $rsmaster !== false;
            }
            if (!$validMasterRecord) {
                $relatedRecordMsg = str_replace("%t", "question_controlobjectives", $Language->phrase("RelatedRecordRequired"));
                $this->setFailureMessage($relatedRecordMsg);
                return false;
            }

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
            if ($masterTblVar == "iso27001_refs") {
                $validMaster = true;
                $masterTbl = Container("iso27001_refs");
                if (($parm = Get("fk_code", Get("refs1"))) !== null) {
                    $masterTbl->code->setQueryStringValue($parm);
                    $this->refs1->setQueryStringValue($masterTbl->code->QueryStringValue);
                    $this->refs1->setSessionValue($this->refs1->QueryStringValue);
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "nist_to_iso27001") {
                $validMaster = true;
                $masterTbl = Container("nist_to_iso27001");
                if (($parm = Get("fk_just_for_question_link", Get("refs1"))) !== null) {
                    $masterTbl->just_for_question_link->setQueryStringValue($parm);
                    $this->refs1->setQueryStringValue($masterTbl->just_for_question_link->QueryStringValue);
                    $this->refs1->setSessionValue($this->refs1->QueryStringValue);
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "question_controlobjectives") {
                $validMaster = true;
                $masterTbl = Container("question_controlobjectives");
                if (($parm = Get("fk_controlObj_name", Get("controlObj_id"))) !== null) {
                    $masterTbl->controlObj_name->setQueryStringValue($parm);
                    $this->controlObj_id->setQueryStringValue($masterTbl->controlObj_name->QueryStringValue);
                    $this->controlObj_id->setSessionValue($this->controlObj_id->QueryStringValue);
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
            if ($masterTblVar == "iso27001_refs") {
                $validMaster = true;
                $masterTbl = Container("iso27001_refs");
                if (($parm = Post("fk_code", Post("refs1"))) !== null) {
                    $masterTbl->code->setFormValue($parm);
                    $this->refs1->setFormValue($masterTbl->code->FormValue);
                    $this->refs1->setSessionValue($this->refs1->FormValue);
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "nist_to_iso27001") {
                $validMaster = true;
                $masterTbl = Container("nist_to_iso27001");
                if (($parm = Post("fk_just_for_question_link", Post("refs1"))) !== null) {
                    $masterTbl->just_for_question_link->setFormValue($parm);
                    $this->refs1->setFormValue($masterTbl->just_for_question_link->FormValue);
                    $this->refs1->setSessionValue($this->refs1->FormValue);
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "question_controlobjectives") {
                $validMaster = true;
                $masterTbl = Container("question_controlobjectives");
                if (($parm = Post("fk_controlObj_name", Post("controlObj_id"))) !== null) {
                    $masterTbl->controlObj_name->setFormValue($parm);
                    $this->controlObj_id->setFormValue($masterTbl->controlObj_name->FormValue);
                    $this->controlObj_id->setSessionValue($this->controlObj_id->FormValue);
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
            if ($masterTblVar != "iso27001_refs") {
                if ($this->refs1->CurrentValue == "") {
                    $this->refs1->setSessionValue("");
                }
            }
            if ($masterTblVar != "nist_to_iso27001") {
                if ($this->refs1->CurrentValue == "") {
                    $this->refs1->setSessionValue("");
                }
            }
            if ($masterTblVar != "question_controlobjectives") {
                if ($this->controlObj_id->CurrentValue == "") {
                    $this->controlObj_id->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("QuestionsLibraryList"), "", $this->TableVar, true);
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
                case "x_controlObj_id":
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
