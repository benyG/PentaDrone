<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for risk_librairies
 */
class RiskLibrairies extends DbTable
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
    public $id;
    public $title;
    public $layer;
    public $function_csf;
    public $tag;
    public $Confidentiality;
    public $Integrity;
    public $Availability;
    public $Efficiency;
    public $created_at;
    public $updated_at;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'risk_librairies';
        $this->TableName = 'risk_librairies';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`risk_librairies`";
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

        // id
        $this->id = new DbField('risk_librairies', 'risk_librairies', 'x_id', 'id', '`id`', '`id`', 19, 10, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['id'] = &$this->id;

        // title
        $this->title = new DbField('risk_librairies', 'risk_librairies', 'x_title', 'title', '`title`', '`title`', 200, 255, -1, false, '`title`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->title->Nullable = false; // NOT NULL field
        $this->title->Required = true; // Required field
        $this->title->Sortable = true; // Allow sort
        $this->Fields['title'] = &$this->title;

        // layer
        $this->layer = new DbField('risk_librairies', 'risk_librairies', 'x_layer', 'layer', '`layer`', '`layer`', 200, 50, -1, false, '`layer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->layer->IsForeignKey = true; // Foreign key field
        $this->layer->Nullable = false; // NOT NULL field
        $this->layer->Required = true; // Required field
        $this->layer->Sortable = true; // Allow sort
        $this->layer->Lookup = new Lookup('layer', 'layers', false, 'name', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->Fields['layer'] = &$this->layer;

        // function_csf
        $this->function_csf = new DbField('risk_librairies', 'risk_librairies', 'x_function_csf', 'function_csf', '`function_csf`', '`function_csf`', 200, 50, -1, false, '`function_csf`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->function_csf->IsForeignKey = true; // Foreign key field
        $this->function_csf->Nullable = false; // NOT NULL field
        $this->function_csf->Required = true; // Required field
        $this->function_csf->Sortable = true; // Allow sort
        $this->function_csf->Lookup = new Lookup('function_csf', 'functions', false, 'name', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->Fields['function_csf'] = &$this->function_csf;

        // tag
        $this->tag = new DbField('risk_librairies', 'risk_librairies', 'x_tag', 'tag', '`tag`', '`tag`', 200, 50, -1, false, '`tag`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tag->Nullable = false; // NOT NULL field
        $this->tag->Required = true; // Required field
        $this->tag->Sortable = true; // Allow sort
        $this->Fields['tag'] = &$this->tag;

        // Confidentiality
        $this->Confidentiality = new DbField('risk_librairies', 'risk_librairies', 'x_Confidentiality', 'Confidentiality', '`Confidentiality`', '`Confidentiality`', 3, 2, -1, false, '`Confidentiality`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->Confidentiality->Nullable = false; // NOT NULL field
        $this->Confidentiality->Required = true; // Required field
        $this->Confidentiality->Sortable = true; // Allow sort
        $this->Confidentiality->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->Confidentiality->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->Confidentiality->Lookup = new Lookup('Confidentiality', 'risk_librairies', false, '', ["","","",""], [], [], [], [], [], [], '', '');
        $this->Confidentiality->OptionCount = 3;
        $this->Confidentiality->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['Confidentiality'] = &$this->Confidentiality;

        // Integrity
        $this->Integrity = new DbField('risk_librairies', 'risk_librairies', 'x_Integrity', 'Integrity', '`Integrity`', '`Integrity`', 3, 2, -1, false, '`Integrity`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->Integrity->Nullable = false; // NOT NULL field
        $this->Integrity->Required = true; // Required field
        $this->Integrity->Sortable = true; // Allow sort
        $this->Integrity->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->Integrity->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->Integrity->Lookup = new Lookup('Integrity', 'risk_librairies', false, '', ["","","",""], [], [], [], [], [], [], '', '');
        $this->Integrity->OptionCount = 3;
        $this->Integrity->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['Integrity'] = &$this->Integrity;

        // Availability
        $this->Availability = new DbField('risk_librairies', 'risk_librairies', 'x_Availability', 'Availability', '`Availability`', '`Availability`', 3, 2, -1, false, '`Availability`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->Availability->Nullable = false; // NOT NULL field
        $this->Availability->Required = true; // Required field
        $this->Availability->Sortable = true; // Allow sort
        $this->Availability->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->Availability->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->Availability->Lookup = new Lookup('Availability', 'risk_librairies', false, '', ["","","",""], [], [], [], [], [], [], '', '');
        $this->Availability->OptionCount = 3;
        $this->Availability->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['Availability'] = &$this->Availability;

        // Efficiency
        $this->Efficiency = new DbField('risk_librairies', 'risk_librairies', 'x_Efficiency', 'Efficiency', '`Efficiency`', '`Efficiency`', 3, 2, -1, false, '`Efficiency`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->Efficiency->Nullable = false; // NOT NULL field
        $this->Efficiency->Required = true; // Required field
        $this->Efficiency->Sortable = true; // Allow sort
        $this->Efficiency->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->Efficiency->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->Efficiency->Lookup = new Lookup('Efficiency', 'risk_librairies', false, '', ["","","",""], [], [], [], [], [], [], '', '');
        $this->Efficiency->OptionCount = 3;
        $this->Efficiency->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['Efficiency'] = &$this->Efficiency;

        // created_at
        $this->created_at = new DbField('risk_librairies', 'risk_librairies', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['created_at'] = &$this->created_at;

        // updated_at
        $this->updated_at = new DbField('risk_librairies', 'risk_librairies', 'x_updated_at', 'updated_at', '`updated_at`', CastDateFieldForLike("`updated_at`", 0, "DB"), 135, 19, 0, false, '`updated_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->updated_at->Sortable = true; // Allow sort
        $this->updated_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['updated_at'] = &$this->updated_at;
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
        if ($this->getCurrentMasterTable() == "layers") {
            if ($this->layer->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`name`", $this->layer->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
        }
        if ($this->getCurrentMasterTable() == "functions") {
            if ($this->function_csf->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`id`", $this->function_csf->getSessionValue(), DATATYPE_NUMBER, "DB");
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
        if ($this->getCurrentMasterTable() == "layers") {
            if ($this->layer->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`layer`", $this->layer->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
        }
        if ($this->getCurrentMasterTable() == "functions") {
            if ($this->function_csf->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`function_csf`", $this->function_csf->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    // Master filter
    public function sqlMasterFilter_layers()
    {
        return "`name`='@name@'";
    }
    // Detail filter
    public function sqlDetailFilter_layers()
    {
        return "`layer`='@layer@'";
    }

    // Master filter
    public function sqlMasterFilter_functions()
    {
        return "`id`=@id@";
    }
    // Detail filter
    public function sqlDetailFilter_functions()
    {
        return "`function_csf`='@function_csf@'";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`risk_librairies`";
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
            // Get insert id if necessary
            $this->id->setDbValue($conn->lastInsertId());
            $rs['id'] = $this->id->DbValue;
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
            if (array_key_exists('id', $rs)) {
                AddFilter($where, QuotedName('id', $this->Dbid) . '=' . QuotedValue($rs['id'], $this->id->DataType, $this->Dbid));
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
        $this->id->DbValue = $row['id'];
        $this->title->DbValue = $row['title'];
        $this->layer->DbValue = $row['layer'];
        $this->function_csf->DbValue = $row['function_csf'];
        $this->tag->DbValue = $row['tag'];
        $this->Confidentiality->DbValue = $row['Confidentiality'];
        $this->Integrity->DbValue = $row['Integrity'];
        $this->Availability->DbValue = $row['Availability'];
        $this->Efficiency->DbValue = $row['Efficiency'];
        $this->created_at->DbValue = $row['created_at'];
        $this->updated_at->DbValue = $row['updated_at'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`id` = @id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->id->CurrentValue : $this->id->OldValue;
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
                $this->id->CurrentValue = $keys[0];
            } else {
                $this->id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id', $row) ? $row['id'] : null;
        } else {
            $val = $this->id->OldValue !== null ? $this->id->OldValue : $this->id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("RiskLibrairiesList");
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
        if ($pageName == "RiskLibrairiesView") {
            return $Language->phrase("View");
        } elseif ($pageName == "RiskLibrairiesEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "RiskLibrairiesAdd") {
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
                return "RiskLibrairiesView";
            case Config("API_ADD_ACTION"):
                return "RiskLibrairiesAdd";
            case Config("API_EDIT_ACTION"):
                return "RiskLibrairiesEdit";
            case Config("API_DELETE_ACTION"):
                return "RiskLibrairiesDelete";
            case Config("API_LIST_ACTION"):
                return "RiskLibrairiesList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "RiskLibrairiesList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("RiskLibrairiesView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("RiskLibrairiesView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "RiskLibrairiesAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "RiskLibrairiesAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("RiskLibrairiesEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("RiskLibrairiesAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("RiskLibrairiesDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "layers" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_name", $this->layer->CurrentValue);
        }
        if ($this->getCurrentMasterTable() == "functions" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id", $this->function_csf->CurrentValue);
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "id:" . JsonEncode($this->id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->id->CurrentValue);
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
            if (($keyValue = Param("id") ?? Route("id")) !== null) {
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
                if (!is_numeric($key)) {
                    continue;
                }
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
                $this->id->CurrentValue = $key;
            } else {
                $this->id->OldValue = $key;
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

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

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
        $this->title->EditValue = $this->title->CurrentValue;
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
            $this->layer->EditValue = $this->layer->CurrentValue;
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
            $this->function_csf->EditValue = $this->function_csf->CurrentValue;
            $this->function_csf->PlaceHolder = RemoveHtml($this->function_csf->caption());
        }

        // tag
        $this->tag->EditAttrs["class"] = "form-control";
        $this->tag->EditCustomAttributes = "";
        if (!$this->tag->Raw) {
            $this->tag->CurrentValue = HtmlDecode($this->tag->CurrentValue);
        }
        $this->tag->EditValue = $this->tag->CurrentValue;
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
        $this->created_at->EditValue = FormatDateTime($this->created_at->CurrentValue, 8);
        $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

        // updated_at
        $this->updated_at->EditAttrs["class"] = "form-control";
        $this->updated_at->EditCustomAttributes = "";
        $this->updated_at->EditValue = FormatDateTime($this->updated_at->CurrentValue, 8);
        $this->updated_at->PlaceHolder = RemoveHtml($this->updated_at->caption());

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
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->title);
                    $doc->exportCaption($this->layer);
                    $doc->exportCaption($this->function_csf);
                    $doc->exportCaption($this->tag);
                    $doc->exportCaption($this->Confidentiality);
                    $doc->exportCaption($this->Integrity);
                    $doc->exportCaption($this->Availability);
                    $doc->exportCaption($this->Efficiency);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->updated_at);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->title);
                    $doc->exportCaption($this->layer);
                    $doc->exportCaption($this->function_csf);
                    $doc->exportCaption($this->tag);
                    $doc->exportCaption($this->Confidentiality);
                    $doc->exportCaption($this->Integrity);
                    $doc->exportCaption($this->Availability);
                    $doc->exportCaption($this->Efficiency);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->updated_at);
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
                        $doc->exportField($this->id);
                        $doc->exportField($this->title);
                        $doc->exportField($this->layer);
                        $doc->exportField($this->function_csf);
                        $doc->exportField($this->tag);
                        $doc->exportField($this->Confidentiality);
                        $doc->exportField($this->Integrity);
                        $doc->exportField($this->Availability);
                        $doc->exportField($this->Efficiency);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->updated_at);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->title);
                        $doc->exportField($this->layer);
                        $doc->exportField($this->function_csf);
                        $doc->exportField($this->tag);
                        $doc->exportField($this->Confidentiality);
                        $doc->exportField($this->Integrity);
                        $doc->exportField($this->Availability);
                        $doc->exportField($this->Efficiency);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->updated_at);
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
