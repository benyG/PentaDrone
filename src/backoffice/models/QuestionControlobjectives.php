<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for question_controlobjectives
 */
class QuestionControlobjectives extends DbTable
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
    public $num_ordre;
    public $controlObj_name;
    public $question_domain_id;
    public $layer_id;
    public $function_csf;
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
        $this->TableVar = 'question_controlobjectives';
        $this->TableName = 'question_controlobjectives';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`question_controlobjectives`";
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

        // num_ordre
        $this->num_ordre = new DbField('question_controlobjectives', 'question_controlobjectives', 'x_num_ordre', 'num_ordre', '`num_ordre`', '`num_ordre`', 3, 30, -1, false, '`num_ordre`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->num_ordre->Nullable = false; // NOT NULL field
        $this->num_ordre->Required = true; // Required field
        $this->num_ordre->Sortable = true; // Allow sort
        $this->num_ordre->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['num_ordre'] = &$this->num_ordre;

        // controlObj_name
        $this->controlObj_name = new DbField('question_controlobjectives', 'question_controlobjectives', 'x_controlObj_name', 'controlObj_name', '`controlObj_name`', '`controlObj_name`', 200, 255, -1, false, '`controlObj_name`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->controlObj_name->IsPrimaryKey = true; // Primary key field
        $this->controlObj_name->IsForeignKey = true; // Foreign key field
        $this->controlObj_name->Nullable = false; // NOT NULL field
        $this->controlObj_name->Required = true; // Required field
        $this->controlObj_name->Sortable = true; // Allow sort
        $this->Fields['controlObj_name'] = &$this->controlObj_name;

        // question_domain_id
        $this->question_domain_id = new DbField('question_controlobjectives', 'question_controlobjectives', 'x_question_domain_id', 'question_domain_id', '`question_domain_id`', '`question_domain_id`', 200, 255, -1, false, '`question_domain_id`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->question_domain_id->IsForeignKey = true; // Foreign key field
        $this->question_domain_id->Nullable = false; // NOT NULL field
        $this->question_domain_id->Required = true; // Required field
        $this->question_domain_id->Sortable = true; // Allow sort
        $this->question_domain_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->question_domain_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->question_domain_id->Lookup = new Lookup('question_domain_id', 'question_domains', false, 'domain_name', ["domain_name","","",""], [], [], [], [], [], [], '', '');
        $this->Fields['question_domain_id'] = &$this->question_domain_id;

        // layer_id
        $this->layer_id = new DbField('question_controlobjectives', 'question_controlobjectives', 'x_layer_id', 'layer_id', '`layer_id`', '`layer_id`', 200, 50, -1, false, '`layer_id`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->layer_id->IsForeignKey = true; // Foreign key field
        $this->layer_id->Nullable = false; // NOT NULL field
        $this->layer_id->Required = true; // Required field
        $this->layer_id->Sortable = true; // Allow sort
        $this->layer_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->layer_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->layer_id->Lookup = new Lookup('layer_id', 'layers', false, 'name', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->Fields['layer_id'] = &$this->layer_id;

        // function_csf
        $this->function_csf = new DbField('question_controlobjectives', 'question_controlobjectives', 'x_function_csf', 'function_csf', '`function_csf`', '`function_csf`', 200, 50, -1, false, '`function_csf`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->function_csf->IsForeignKey = true; // Foreign key field
        $this->function_csf->Nullable = false; // NOT NULL field
        $this->function_csf->Required = true; // Required field
        $this->function_csf->Sortable = true; // Allow sort
        $this->function_csf->Lookup = new Lookup('function_csf', 'functions', false, 'name', ["name","","",""], [], [], [], [], [], [], '', '');
        $this->Fields['function_csf'] = &$this->function_csf;

        // created_at
        $this->created_at = new DbField('question_controlobjectives', 'question_controlobjectives', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['created_at'] = &$this->created_at;

        // updated_at
        $this->updated_at = new DbField('question_controlobjectives', 'question_controlobjectives', 'x_updated_at', 'updated_at', '`updated_at`', CastDateFieldForLike("`updated_at`", 0, "DB"), 135, 19, 0, false, '`updated_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
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
        if ($this->getCurrentMasterTable() == "question_domains") {
            if ($this->question_domain_id->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`domain_name`", $this->question_domain_id->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
        }
        if ($this->getCurrentMasterTable() == "layers") {
            if ($this->layer_id->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`name`", $this->layer_id->getSessionValue(), DATATYPE_STRING, "DB");
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
        if ($this->getCurrentMasterTable() == "question_domains") {
            if ($this->question_domain_id->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`question_domain_id`", $this->question_domain_id->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
        }
        if ($this->getCurrentMasterTable() == "layers") {
            if ($this->layer_id->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`layer_id`", $this->layer_id->getSessionValue(), DATATYPE_STRING, "DB");
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
    public function sqlMasterFilter_question_domains()
    {
        return "`domain_name`='@domain_name@'";
    }
    // Detail filter
    public function sqlDetailFilter_question_domains()
    {
        return "`question_domain_id`='@question_domain_id@'";
    }

    // Master filter
    public function sqlMasterFilter_layers()
    {
        return "`name`='@name@'";
    }
    // Detail filter
    public function sqlDetailFilter_layers()
    {
        return "`layer_id`='@layer_id@'";
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
        if ($this->getCurrentDetailTable() == "questions_library") {
            $detailUrl = Container("questions_library")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_controlObj_name", $this->controlObj_name->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "QuestionControlobjectivesList";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`question_controlobjectives`";
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
        // Cascade Update detail table 'questions_library'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['controlObj_name']) && $rsold['controlObj_name'] != $rs['controlObj_name'])) { // Update detail field 'controlObj_id'
            $cascadeUpdate = true;
            $rscascade['controlObj_id'] = $rs['controlObj_name'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("questions_library")->loadRs("`controlObj_id` = " . QuotedValue($rsold['controlObj_name'], DATATYPE_STRING, 'DB'))->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("questions_library")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("questions_library")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("questions_library")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

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
            if (array_key_exists('controlObj_name', $rs)) {
                AddFilter($where, QuotedName('controlObj_name', $this->Dbid) . '=' . QuotedValue($rs['controlObj_name'], $this->controlObj_name->DataType, $this->Dbid));
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

        // Cascade delete detail table 'questions_library'
        $dtlrows = Container("questions_library")->loadRs("`controlObj_id` = " . QuotedValue($rs['controlObj_name'], DATATYPE_STRING, "DB"))->fetchAll(\PDO::FETCH_ASSOC);
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("questions_library")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("questions_library")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("questions_library")->rowDeleted($dtlrow);
            }
        }
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
        $this->num_ordre->DbValue = $row['num_ordre'];
        $this->controlObj_name->DbValue = $row['controlObj_name'];
        $this->question_domain_id->DbValue = $row['question_domain_id'];
        $this->layer_id->DbValue = $row['layer_id'];
        $this->function_csf->DbValue = $row['function_csf'];
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
        return "`controlObj_name` = '@controlObj_name@'";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->controlObj_name->CurrentValue : $this->controlObj_name->OldValue;
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
                $this->controlObj_name->CurrentValue = $keys[0];
            } else {
                $this->controlObj_name->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('controlObj_name', $row) ? $row['controlObj_name'] : null;
        } else {
            $val = $this->controlObj_name->OldValue !== null ? $this->controlObj_name->OldValue : $this->controlObj_name->CurrentValue;
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@controlObj_name@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("QuestionControlobjectivesList");
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
        if ($pageName == "QuestionControlobjectivesView") {
            return $Language->phrase("View");
        } elseif ($pageName == "QuestionControlobjectivesEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "QuestionControlobjectivesAdd") {
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
                return "QuestionControlobjectivesView";
            case Config("API_ADD_ACTION"):
                return "QuestionControlobjectivesAdd";
            case Config("API_EDIT_ACTION"):
                return "QuestionControlobjectivesEdit";
            case Config("API_DELETE_ACTION"):
                return "QuestionControlobjectivesDelete";
            case Config("API_LIST_ACTION"):
                return "QuestionControlobjectivesList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "QuestionControlobjectivesList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("QuestionControlobjectivesView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("QuestionControlobjectivesView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "QuestionControlobjectivesAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "QuestionControlobjectivesAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("QuestionControlobjectivesEdit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("QuestionControlobjectivesEdit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
            $url = $this->keyUrl("QuestionControlobjectivesAdd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("QuestionControlobjectivesAdd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
        return $this->keyUrl("QuestionControlobjectivesDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "question_domains" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_domain_name", $this->question_domain_id->CurrentValue);
        }
        if ($this->getCurrentMasterTable() == "layers" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_name", $this->layer_id->CurrentValue);
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
        $json .= "controlObj_name:" . JsonEncode($this->controlObj_name->CurrentValue, "string");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->controlObj_name->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->controlObj_name->CurrentValue);
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
            if (($keyValue = Param("controlObj_name") ?? Route("controlObj_name")) !== null) {
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
                $this->controlObj_name->CurrentValue = $key;
            } else {
                $this->controlObj_name->OldValue = $key;
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
        $this->num_ordre->setDbValue($row['num_ordre']);
        $this->controlObj_name->setDbValue($row['controlObj_name']);
        $this->question_domain_id->setDbValue($row['question_domain_id']);
        $this->layer_id->setDbValue($row['layer_id']);
        $this->function_csf->setDbValue($row['function_csf']);
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

        // num_ordre

        // controlObj_name

        // question_domain_id

        // layer_id

        // function_csf

        // created_at

        // updated_at

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

        // num_ordre
        $this->num_ordre->EditAttrs["class"] = "form-control";
        $this->num_ordre->EditCustomAttributes = "";
        $this->num_ordre->EditValue = $this->num_ordre->CurrentValue;
        $this->num_ordre->PlaceHolder = RemoveHtml($this->num_ordre->caption());

        // controlObj_name
        $this->controlObj_name->EditAttrs["class"] = "form-control";
        $this->controlObj_name->EditCustomAttributes = "";
        if (!$this->controlObj_name->Raw) {
            $this->controlObj_name->CurrentValue = HtmlDecode($this->controlObj_name->CurrentValue);
        }
        $this->controlObj_name->EditValue = $this->controlObj_name->CurrentValue;
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
            $this->function_csf->EditValue = $this->function_csf->CurrentValue;
            $this->function_csf->PlaceHolder = RemoveHtml($this->function_csf->caption());
        }

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
                    $doc->exportCaption($this->num_ordre);
                    $doc->exportCaption($this->controlObj_name);
                    $doc->exportCaption($this->question_domain_id);
                    $doc->exportCaption($this->layer_id);
                    $doc->exportCaption($this->function_csf);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->updated_at);
                } else {
                    $doc->exportCaption($this->num_ordre);
                    $doc->exportCaption($this->controlObj_name);
                    $doc->exportCaption($this->question_domain_id);
                    $doc->exportCaption($this->layer_id);
                    $doc->exportCaption($this->function_csf);
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
                        $doc->exportField($this->num_ordre);
                        $doc->exportField($this->controlObj_name);
                        $doc->exportField($this->question_domain_id);
                        $doc->exportField($this->layer_id);
                        $doc->exportField($this->function_csf);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->updated_at);
                    } else {
                        $doc->exportField($this->num_ordre);
                        $doc->exportField($this->controlObj_name);
                        $doc->exportField($this->question_domain_id);
                        $doc->exportField($this->layer_id);
                        $doc->exportField($this->function_csf);
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
