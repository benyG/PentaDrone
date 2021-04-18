<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for cis_refs
 */
class CisRefs extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Export
    public $ExportDoc;

    // Fields
    public $Nidentifier;
    public $Control_Family_id;
    public $control_Name;
    public $control_description;
    public $impl_group1;
    public $impl_group2;
    public $impl_group3;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'cis_refs';
        $this->TableName = 'cis_refs';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`cis_refs`";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // Nidentifier
        $this->Nidentifier = new DbField('cis_refs', 'cis_refs', 'x_Nidentifier', 'Nidentifier', '`Nidentifier`', '`Nidentifier`', 200, 9, -1, false, '`Nidentifier`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Nidentifier->IsPrimaryKey = true; // Primary key field
        $this->Nidentifier->IsForeignKey = true; // Foreign key field
        $this->Nidentifier->Nullable = false; // NOT NULL field
        $this->Nidentifier->Required = true; // Required field
        $this->Nidentifier->Sortable = true; // Allow sort
        $this->Fields['Nidentifier'] = &$this->Nidentifier;

        // Control_Family_id
        $this->Control_Family_id = new DbField('cis_refs', 'cis_refs', 'x_Control_Family_id', 'Control_Family_id', '`Control_Family_id`', '`Control_Family_id`', 200, 3, -1, false, '`Control_Family_id`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Control_Family_id->IsForeignKey = true; // Foreign key field
        $this->Control_Family_id->Sortable = true; // Allow sort
        $this->Fields['Control_Family_id'] = &$this->Control_Family_id;

        // control_Name
        $this->control_Name = new DbField('cis_refs', 'cis_refs', 'x_control_Name', 'control_Name', '`control_Name`', '`control_Name`', 200, 255, -1, false, '`control_Name`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->control_Name->Sortable = true; // Allow sort
        $this->Fields['control_Name'] = &$this->control_Name;

        // control_description
        $this->control_description = new DbField('cis_refs', 'cis_refs', 'x_control_description', 'control_description', '`control_description`', '`control_description`', 201, 65535, -1, false, '`control_description`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->control_description->Sortable = true; // Allow sort
        $this->Fields['control_description'] = &$this->control_description;

        // impl_group1
        $this->impl_group1 = new DbField('cis_refs', 'cis_refs', 'x_impl_group1', 'impl_group1', '`impl_group1`', '`impl_group1`', 200, 2, -1, false, '`impl_group1`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->impl_group1->Sortable = true; // Allow sort
        $this->Fields['impl_group1'] = &$this->impl_group1;

        // impl_group2
        $this->impl_group2 = new DbField('cis_refs', 'cis_refs', 'x_impl_group2', 'impl_group2', '`impl_group2`', '`impl_group2`', 200, 2, -1, false, '`impl_group2`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->impl_group2->Sortable = true; // Allow sort
        $this->Fields['impl_group2'] = &$this->impl_group2;

        // impl_group3
        $this->impl_group3 = new DbField('cis_refs', 'cis_refs', 'x_impl_group3', 'impl_group3', '`impl_group3`', '`impl_group3`', 200, 2, -1, false, '`impl_group3`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->impl_group3->Sortable = true; // Allow sort
        $this->Fields['impl_group3'] = &$this->impl_group3;
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        } else {
            $fld->setSort("");
        }
    }

    // Current master table name
    public function getCurrentMasterTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE"));
    }

    public function setCurrentMasterTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")] = $v;
    }

    // Session master WHERE clause
    public function getMasterFilter()
    {
        // Master filter
        $masterFilter = "";
        if ($this->getCurrentMasterTable() == "cis_refs_controlfamily") {
            if ($this->Control_Family_id->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`code`", $this->Control_Family_id->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
        }
        return $masterFilter;
    }

    // Session detail WHERE clause
    public function getDetailFilter()
    {
        // Detail filter
        $detailFilter = "";
        if ($this->getCurrentMasterTable() == "cis_refs_controlfamily") {
            if ($this->Control_Family_id->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`Control_Family_id`", $this->Control_Family_id->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    // Master filter
    public function sqlMasterFilter_cis_refs_controlfamily()
    {
        return "`code`='@code@'";
    }
    // Detail filter
    public function sqlDetailFilter_cis_refs_controlfamily()
    {
        return "`Control_Family_id`='@Control_Family_id@'";
    }

    // Current detail table name
    public function getCurrentDetailTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE"));
    }

    public function setCurrentDetailTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")] = $v;
    }

    // Get detail url
    public function getDetailUrl()
    {
        // Detail url
        $detailUrl = "";
        if ($this->getCurrentDetailTable() == "subcat_cis_links") {
            $detailUrl = Container("subcat_cis_links")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Nidentifier", $this->Nidentifier->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "CisRefsList";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`cis_refs`";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*");
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : $this->DefaultSort;
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter)
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            default:
                return (($allow & 8) == 8);
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $rs = null;
        if ($sql instanceof \Doctrine\DBAL\Query\QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $rs = $conn->executeQuery($sqlwrk);
        $cnt = $rs->fetchColumn();
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        )->getSQL();
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    protected function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->setValue($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        $success = $this->insertSql($rs)->execute();
        if ($success) {
        }
        return $success;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->set($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('Nidentifier', $rs)) {
                AddFilter($where, QuotedName('Nidentifier', $this->Dbid) . '=' . QuotedValue($rs['Nidentifier'], $this->Nidentifier->DataType, $this->Dbid));
            }
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            $success = $this->deleteSql($rs, $where, $curfilter)->execute();
        }
        return $success;
    }

    // Load DbValue from recordset or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->Nidentifier->DbValue = $row['Nidentifier'];
        $this->Control_Family_id->DbValue = $row['Control_Family_id'];
        $this->control_Name->DbValue = $row['control_Name'];
        $this->control_description->DbValue = $row['control_description'];
        $this->impl_group1->DbValue = $row['impl_group1'];
        $this->impl_group2->DbValue = $row['impl_group2'];
        $this->impl_group3->DbValue = $row['impl_group3'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Nidentifier` = '@Nidentifier@'";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->Nidentifier->CurrentValue : $this->Nidentifier->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->Nidentifier->CurrentValue = $keys[0];
            } else {
                $this->Nidentifier->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Nidentifier', $row) ? $row['Nidentifier'] : null;
        } else {
            $val = $this->Nidentifier->OldValue !== null ? $this->Nidentifier->OldValue : $this->Nidentifier->CurrentValue;
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Nidentifier@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("CisRefsList");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "CisRefsView") {
            return $Language->phrase("View");
        } elseif ($pageName == "CisRefsEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "CisRefsAdd") {
            return $Language->phrase("Add");
        } else {
            return "";
        }
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "CisRefsView";
            case Config("API_ADD_ACTION"):
                return "CisRefsAdd";
            case Config("API_EDIT_ACTION"):
                return "CisRefsEdit";
            case Config("API_DELETE_ACTION"):
                return "CisRefsDelete";
            case Config("API_LIST_ACTION"):
                return "CisRefsList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "CisRefsList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("CisRefsView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("CisRefsView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "CisRefsAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "CisRefsAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("CisRefsEdit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("CisRefsEdit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("CisRefsAdd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("CisRefsAdd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        return $this->keyUrl("CisRefsDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "cis_refs_controlfamily" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_code", $this->Control_Family_id->CurrentValue);
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "Nidentifier:" . JsonEncode($this->Nidentifier->CurrentValue, "string");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Nidentifier->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->Nidentifier->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderSort($fld)
    {
        $classId = $fld->TableVar . "_" . $fld->Param;
        $scriptId = str_replace("%id%", $classId, "tpc_%id%");
        $scriptStart = $this->UseCustomTemplate ? "<template id=\"" . $scriptId . "\">" : "";
        $scriptEnd = $this->UseCustomTemplate ? "</template>" : "";
        $jsSort = " class=\"ew-pointer\" onclick=\"ew.sort(event, '" . $this->sortUrl($fld) . "', 1);\"";
        if ($this->sortUrl($fld) == "") {
            $html = <<<NOSORTHTML
{$scriptStart}<div class="ew-table-header-caption">{$fld->caption()}</div>{$scriptEnd}
NOSORTHTML;
        } else {
            if ($fld->getSort() == "ASC") {
                $sortIcon = '<i class="fas fa-sort-up"></i>';
            } elseif ($fld->getSort() == "DESC") {
                $sortIcon = '<i class="fas fa-sort-down"></i>';
            } else {
                $sortIcon = '';
            }
            $html = <<<SORTHTML
{$scriptStart}<div{$jsSort}><div class="ew-table-header-btn"><span class="ew-table-header-caption">{$fld->caption()}</span><span class="ew-table-header-sort">{$sortIcon}</span></div></div>{$scriptEnd}
SORTHTML;
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort());
            return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            if (($keyValue = Param("Nidentifier") ?? Route("Nidentifier")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->Nidentifier->CurrentValue = $key;
            } else {
                $this->Nidentifier->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load recordset based on filter
    public function &loadRs($filter)
    {
        $sql = $this->getSql($filter); // Set up filter (WHERE Clause)
        $conn = $this->getConnection();
        $stmt = $conn->executeQuery($sql);
        return $stmt;
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
        $this->Nidentifier->setDbValue($row['Nidentifier']);
        $this->Control_Family_id->setDbValue($row['Control_Family_id']);
        $this->control_Name->setDbValue($row['control_Name']);
        $this->control_description->setDbValue($row['control_description']);
        $this->impl_group1->setDbValue($row['impl_group1']);
        $this->impl_group2->setDbValue($row['impl_group2']);
        $this->impl_group3->setDbValue($row['impl_group3']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // Nidentifier

        // Control_Family_id

        // control_Name

        // control_description

        // impl_group1

        // impl_group2

        // impl_group3

        // Nidentifier
        $this->Nidentifier->ViewValue = $this->Nidentifier->CurrentValue;
        $this->Nidentifier->ViewCustomAttributes = "";

        // Control_Family_id
        $this->Control_Family_id->ViewValue = $this->Control_Family_id->CurrentValue;
        $this->Control_Family_id->ViewCustomAttributes = "";

        // control_Name
        $this->control_Name->ViewValue = $this->control_Name->CurrentValue;
        $this->control_Name->ViewCustomAttributes = "";

        // control_description
        $this->control_description->ViewValue = $this->control_description->CurrentValue;
        $this->control_description->ViewCustomAttributes = "";

        // impl_group1
        $this->impl_group1->ViewValue = $this->impl_group1->CurrentValue;
        $this->impl_group1->ViewCustomAttributes = "";

        // impl_group2
        $this->impl_group2->ViewValue = $this->impl_group2->CurrentValue;
        $this->impl_group2->ViewCustomAttributes = "";

        // impl_group3
        $this->impl_group3->ViewValue = $this->impl_group3->CurrentValue;
        $this->impl_group3->ViewCustomAttributes = "";

        // Nidentifier
        $this->Nidentifier->LinkCustomAttributes = "";
        $this->Nidentifier->HrefValue = "";
        $this->Nidentifier->TooltipValue = "";

        // Control_Family_id
        $this->Control_Family_id->LinkCustomAttributes = "";
        $this->Control_Family_id->HrefValue = "";
        $this->Control_Family_id->TooltipValue = "";

        // control_Name
        $this->control_Name->LinkCustomAttributes = "";
        $this->control_Name->HrefValue = "";
        $this->control_Name->TooltipValue = "";

        // control_description
        $this->control_description->LinkCustomAttributes = "";
        $this->control_description->HrefValue = "";
        $this->control_description->TooltipValue = "";

        // impl_group1
        $this->impl_group1->LinkCustomAttributes = "";
        $this->impl_group1->HrefValue = "";
        $this->impl_group1->TooltipValue = "";

        // impl_group2
        $this->impl_group2->LinkCustomAttributes = "";
        $this->impl_group2->HrefValue = "";
        $this->impl_group2->TooltipValue = "";

        // impl_group3
        $this->impl_group3->LinkCustomAttributes = "";
        $this->impl_group3->HrefValue = "";
        $this->impl_group3->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Nidentifier
        $this->Nidentifier->EditAttrs["class"] = "form-control";
        $this->Nidentifier->EditCustomAttributes = "";
        if (!$this->Nidentifier->Raw) {
            $this->Nidentifier->CurrentValue = HtmlDecode($this->Nidentifier->CurrentValue);
        }
        $this->Nidentifier->EditValue = $this->Nidentifier->CurrentValue;
        $this->Nidentifier->PlaceHolder = RemoveHtml($this->Nidentifier->caption());

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
            $this->Control_Family_id->EditValue = $this->Control_Family_id->CurrentValue;
            $this->Control_Family_id->PlaceHolder = RemoveHtml($this->Control_Family_id->caption());
        }

        // control_Name
        $this->control_Name->EditAttrs["class"] = "form-control";
        $this->control_Name->EditCustomAttributes = "";
        if (!$this->control_Name->Raw) {
            $this->control_Name->CurrentValue = HtmlDecode($this->control_Name->CurrentValue);
        }
        $this->control_Name->EditValue = $this->control_Name->CurrentValue;
        $this->control_Name->PlaceHolder = RemoveHtml($this->control_Name->caption());

        // control_description
        $this->control_description->EditAttrs["class"] = "form-control";
        $this->control_description->EditCustomAttributes = "";
        $this->control_description->EditValue = $this->control_description->CurrentValue;
        $this->control_description->PlaceHolder = RemoveHtml($this->control_description->caption());

        // impl_group1
        $this->impl_group1->EditAttrs["class"] = "form-control";
        $this->impl_group1->EditCustomAttributes = "";
        if (!$this->impl_group1->Raw) {
            $this->impl_group1->CurrentValue = HtmlDecode($this->impl_group1->CurrentValue);
        }
        $this->impl_group1->EditValue = $this->impl_group1->CurrentValue;
        $this->impl_group1->PlaceHolder = RemoveHtml($this->impl_group1->caption());

        // impl_group2
        $this->impl_group2->EditAttrs["class"] = "form-control";
        $this->impl_group2->EditCustomAttributes = "";
        if (!$this->impl_group2->Raw) {
            $this->impl_group2->CurrentValue = HtmlDecode($this->impl_group2->CurrentValue);
        }
        $this->impl_group2->EditValue = $this->impl_group2->CurrentValue;
        $this->impl_group2->PlaceHolder = RemoveHtml($this->impl_group2->caption());

        // impl_group3
        $this->impl_group3->EditAttrs["class"] = "form-control";
        $this->impl_group3->EditCustomAttributes = "";
        if (!$this->impl_group3->Raw) {
            $this->impl_group3->CurrentValue = HtmlDecode($this->impl_group3->CurrentValue);
        }
        $this->impl_group3->EditValue = $this->impl_group3->CurrentValue;
        $this->impl_group3->PlaceHolder = RemoveHtml($this->impl_group3->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$recordset || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->Nidentifier);
                    $doc->exportCaption($this->Control_Family_id);
                    $doc->exportCaption($this->control_Name);
                    $doc->exportCaption($this->control_description);
                    $doc->exportCaption($this->impl_group1);
                    $doc->exportCaption($this->impl_group2);
                    $doc->exportCaption($this->impl_group3);
                } else {
                    $doc->exportCaption($this->Nidentifier);
                    $doc->exportCaption($this->Control_Family_id);
                    $doc->exportCaption($this->control_Name);
                    $doc->exportCaption($this->impl_group1);
                    $doc->exportCaption($this->impl_group2);
                    $doc->exportCaption($this->impl_group3);
                }
                $doc->endExportRow();
            }
        }

        // Move to first record
        $recCnt = $startRec - 1;
        $stopRec = ($stopRec > 0) ? $stopRec : PHP_INT_MAX;
        while (!$recordset->EOF && $recCnt < $stopRec) {
            $row = $recordset->fields;
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = ROWTYPE_VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->Nidentifier);
                        $doc->exportField($this->Control_Family_id);
                        $doc->exportField($this->control_Name);
                        $doc->exportField($this->control_description);
                        $doc->exportField($this->impl_group1);
                        $doc->exportField($this->impl_group2);
                        $doc->exportField($this->impl_group3);
                    } else {
                        $doc->exportField($this->Nidentifier);
                        $doc->exportField($this->Control_Family_id);
                        $doc->exportField($this->control_Name);
                        $doc->exportField($this->impl_group1);
                        $doc->exportField($this->impl_group2);
                        $doc->exportField($this->impl_group3);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($row);
            }
            $recordset->moveNext();
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        // No binary fields
        return false;
    }

    // Table level events

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected(&$rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email); var_dump($args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}