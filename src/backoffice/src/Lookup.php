<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Lookup class
 */
class Lookup
{
    public $LookupType = "";
    public $Options = null;
    public $Template = "";
    public $CurrentFilter = "";
    public $UserSelect = "";
    public $UserFilter = "";
    public $UserOrderBy = "";
    public $FilterFields = [];
    public $FilterValues = [];
    public $SearchValue = "";
    public $PageSize = -1;
    public $Offset = -1;
    public $ModalLookupSearchType = "";
    public $KeepCrLf = false;
    public $LookupFilter = "";
    public $RenderViewFunc = "renderListRow";
    public $RenderEditFunc = "renderEditRow";
    public $LinkTable = "";
    public $Name = "";
    public $Distinct = false;
    public $LinkField = "";
    public $DisplayFields = [];
    public $ParentFields = [];
    public $ChildFields = [];
    public $FilterFieldVars = [];
    public $AutoFillSourceFields = [];
    public $AutoFillTargetFields = [];
    public $Table = null;
    public $FormatAutoFill = false;
    public $UseParentFilter = false;
    private $rendering = false;

    /**
     * Constructor for the Lookup class
     *
     * @param string $name
     * @param string $linkTable
     * @param bool $distinct
     * @param string $linkField
     * @param array $displayFields
     * @param array $parentFields
     * @param array $childFields
     * @param array $filterFields
     * @param array $filterFieldVars
     * @param array $autoFillSourceFields
     * @param array $autoFillTargetFields
     * @param string $orderBy
     * @param string $template
     */
    public function __construct(
        $name,
        $linkTable,
        $distinct,
        $linkField,
        $displayFields = [],
        $parentFields = [],
        $childFields = [],
        $filterFields = [],
        $filterFieldVars = [],
        $autoFillSourceFields = [],
        $autoFillTargetFields = [],
        $orderBy = "",
        $template = ""
    ) {
        $this->Name = $name;
        $this->LinkTable = $linkTable;
        $this->Distinct = $distinct;
        $this->LinkField = $linkField;
        $this->DisplayFields = $displayFields;
        $this->ParentFields = $parentFields;
        $this->ChildFields = $childFields;
        foreach ($filterFields as $filterField) {
            $this->FilterFields[$filterField] = "="; // Default filter operator
        }
        $this->FilterFieldVars = $filterFieldVars;
        $this->AutoFillSourceFields = $autoFillSourceFields;
        $this->AutoFillTargetFields = $autoFillTargetFields;
        $this->UserOrderBy = $orderBy;
        $this->Template = $template;
    }

    /**
     * Get lookup SQL based on current filter/lookup filter, call Lookup_Selecting if necessary
     *
     * @param bool $useParentFilter
     * @param string $currentFilter
     * @param string|callable $lookupFilter
     * @param object $page
     * @param bool $skipFilterFields
     * @return QueryBuilder
     */
    public function getSql($useParentFilter = true, $currentFilter = "", $lookupFilter = "", $page = null, $skipFilterFields = false, $clearUserFilter = false)
    {
        $this->UseParentFilter = $useParentFilter; // Save last call
        $this->CurrentFilter = $currentFilter;
        $this->LookupFilter = $lookupFilter; // Save last call
        if ($clearUserFilter) {
            $this->UserFilter = "";
        }
        if ($page !== null) {
            $filter = $this->getUserFilter($useParentFilter);
            $newFilter = $filter;
            $fld = @$page->Fields[$this->Name];
            if ($fld && method_exists($page, "lookupSelecting")) {
                $page->lookupSelecting($fld, $newFilter); // Call Lookup Selecting
            }
            if ($filter != $newFilter) { // Filter changed
                AddFilter($this->UserFilter, $newFilter);
            }
        }
        if ($lookupFilter != "") { // Add lookup filter as part of user filter
            AddFilter($this->UserFilter, $lookupFilter);
        }
        return $this->getSqlPart("", true, $useParentFilter, $skipFilterFields);
    }

    /**
     * Set options
     *
     * @param array $options Input options with formats:
     *  1. Manual input data, e.g.: [ ["lv1", "dv", "dv2", "dv3", "dv4"], ["lv2", "dv", "dv2", "dv3", "dv4"], etc...]
     *  2. Data from $rs->getRows(), e.g.: [ [0 => "lv1", "Field1" => "lv1", 1 => "dv", "Field2" => "dv2", ...], [0 => "lv2", "Field1" => "lv2", 1 => "dv", "Field2" => "dv2", ...], etc...]
     * @return bool Output array ["lv1" => [0 => "lv1", "lf" => "lv1", 1 => "dv", "df" => "dv", etc...], etc...]
     */
    public function setOptions($options)
    {
        $opts = $this->formatOptions($options);
        if ($opts === null) {
            return false;
        }
        $this->Options = $opts;
        return true;
    }

    /**
     * Set filter field operator
     *
     * @param string $name Filter field name
     * @param string $opr Filter search operator
     * @return void
     */
    public function setFilterOperator($name, $opr)
    {
        if (array_key_exists($name, $this->FilterFields) && $this->isValidOperator($opr)) {
            $this->FilterFields[$name] = $opr;
        }
    }

    /**
     * Get user parameters hidden tag, if user SELECT/WHERE/ORDER BY clause is not empty
     *
     * @param string $var Variable name
     * @return string
     */
    public function getParamTag($currentPage, $var)
    {
        $this->UserSelect = "";
        $this->UserFilter = "";
        $this->UserOrderBy = "";
        $this->getSql($this->UseParentFilter, $this->CurrentFilter, $this->LookupFilter, $currentPage); // Call Lookup_Selecting again based on last setting
        $ar = [];
        if ($this->UserSelect != "") {
            $ar["s"] = Encrypt($this->UserSelect);
        }
        if ($this->UserFilter != "") {
            $ar["f"] = Encrypt($this->UserFilter);
        }
        if ($this->UserOrderBy != "") {
            $ar["o"] = Encrypt($this->UserOrderBy);
        }
        if (count($ar) > 0) {
            return '<input type="hidden" id="' . $var . '" name="' . $var . '" value="' . http_build_query($ar) . '">';
        }
        return "";
    }

    /**
     * Output client side list
     *
     * @return string
     */
    public function toClientList($currentPage)
    {
        return [
            "page" => $currentPage->PageObjName,
            "field" => $this->Name,
            "linkField" => $this->LinkField,
            "displayFields" => $this->DisplayFields,
            "parentFields" => $this->ParentFields,
            "childFields" => $this->ChildFields,
            "filterFields" => array_keys($this->FilterFields),
            "filterFieldVars" => $this->FilterFieldVars,
            "ajax" => $this->LinkTable != "",
            "autoFillTargetFields" => $this->AutoFillTargetFields,
            "template" => $this->Template
        ];
    }

    /**
     * Execute SQL and write JSON response
     *
     * @return bool
     */
    public function toJson($page = null)
    {
        if ($page === null) {
            return false;
        }

        // Get table object
        $tbl = $this->getTable();

        // Check if lookup to report source table
        $isReport = $page->TableType == "REPORT" && in_array($tbl->TableVar, [$page->ReportSourceTable, $page->TableVar]);
        $renderer = $isReport ? $page : $tbl;

        // Update expression for grouping fields (reports)
        if ($isReport) {
            foreach ($this->DisplayFields as $i => $displayField) {
                if (!EmptyValue($displayField)) {
                    $pageDisplayField = @$page->Fields[$displayField];
                    $tblDisplayField = @$tbl->Fields[$displayField];
                    if ($pageDisplayField && $tblDisplayField && !EmptyValue($pageDisplayField->LookupExpression)) {
                        if (!EmptyValue($this->UserOrderBy)) {
                            $this->UserOrderBy = str_replace($tblDisplayField->Expression, $pageDisplayField->LookupExpression, $this->UserOrderBy);
                        }
                        $tblDisplayField->Expression = $pageDisplayField->LookupExpression;
                        $this->Distinct = true; // Use DISTINCT for grouping fields
                    }
                }
            }
        }
        $sql = $this->getSql(true, "", "", $page);
        $orderBy = $this->UserOrderBy;
        $pageSize = $this->PageSize;
        $offset = $this->Offset;
        $tableCnt = ($pageSize > 0) ? $tbl->getRecordCount($sql) : 0; // Get table count first
        $stmt = $this->executeQuery($sql, $orderBy, $pageSize, $offset);
        if ($stmt) {
            $rsarr = $stmt->fetchAll(\PDO::FETCH_BOTH);
            $rowCnt = count($rsarr);
            $totalCnt = ($pageSize > 0) ? $tableCnt : $rowCnt;
            $fldCnt = $stmt->columnCount();
            $stmt->closeCursor();

            // Clean output buffer
            if (ob_get_length()) {
                ob_clean();
            }

            // Output
            foreach ($rsarr as &$row) {
                for ($i = 1; $i < $fldCnt; $i++) {
                    $str = ConvertToUtf8(strval($row[$i]));
                    $str = str_replace(["\r", "\n", "\t"], $this->KeepCrLf ? ["\\r", "\\n", "\\t"] : [" ", " ", " "], $str);
                    $row[$i] = $str;
                    if (SameText($this->LookupType, "autofill")) {
                        $autoFillSourceField = @$this->AutoFillSourceFields[$i - 1];
                        $autoFillSourceField = @$renderer->Fields[$autoFillSourceField];
                        if ($autoFillSourceField) {
                            $autoFillSourceField->setDbValue($row[$i]);
                        }
                    }
                }
                if (SameText($this->LookupType, "autofill")) {
                    if ($this->FormatAutoFill) { // Format auto fill
                        $renderer->RowType = ROWTYPE_EDIT;
                        $fn = $this->RenderEditFunc;
                        $render = method_exists($renderer, $fn);
                        if ($render) {
                            $renderer->$fn();
                        }
                        for ($i = 0; $i < $fldCnt; $i++) {
                            $autoFillSourceField = @$this->AutoFillSourceFields[$i];
                            $autoFillSourceField = @$renderer->Fields[$autoFillSourceField];
                            if ($autoFillSourceField) {
                                $row["af" . $i] = (!$render || $autoFillSourceField->AutoFillOriginalValue) ? $autoFillSourceField->CurrentValue : ((is_array($autoFillSourceField->EditValue) || $autoFillSourceField->EditValue === null) ? $autoFillSourceField->CurrentValue : $autoFillSourceField->EditValue);
                            }
                        }
                    }
                } elseif ($this->LookupType != "unknown") { // Format display fields for known lookup type
                    $row = $this->renderViewRow($row, $renderer);
                }
            }

            // Set up advanced filter (reports)
            if ($isReport) {
                if (in_array($this->LookupType, ["updateoption", "modal"])) {
                    if (method_exists($page, "pageFilterLoad")) {
                        $page->pageFilterLoad();
                    }
                    $linkField = @$page->Fields[$this->LinkField];
                    if ($linkField && is_array($linkField->AdvancedFilters)) {
                        $ar = [];
                        foreach ($linkField->AdvancedFilters as $filter) {
                            if ($filter->Enabled) {
                                $ar[] = [0 => $filter->ID, "lf" => $filter->ID, 1 => $filter->Name, "df" => $filter->Name];
                            }
                        }
                        $rsarr = array_merge($ar, $rsarr);
                    }
                }
            }
            $result = ["result" => "OK", "records" => $rsarr, "totalRecordCount" => $totalCnt];
            if (Config("DEBUG")) {
                $result["sql"] = is_string($sql) ? $sql : $sql->getSQL();
            }
            WriteJson($result);
            return true;
        }
        return false;
    }

    /**
     * Render view row
     *
     * @param object $row Input data
     * @param object $renderer Renderer
     * @return object Output data
     */
    public function renderViewRow($row, $renderer = null)
    {
        if ($this->rendering) { // Avoid recursive calls
            return $row;
        }

        // Use table as renderer if not defined
        if ($renderer == null) {
            $renderer = $this->getTable();
        }

        // Check if render View function exists
        $renderer->RowType = ROWTYPE_VIEW;
        $fn = $this->RenderViewFunc;
        $render = method_exists($renderer, $fn);
        if (!$render) {
            return $row;
        }
        $this->rendering = true;

        // Set up DbValue / CurrentValue
        foreach ($this->DisplayFields as $index => $name) {
            $displayField = @$renderer->Fields[$name];
            if ($displayField) {
                $sfx = $index > 0 ? $index + 1 : "";
                $displayField->setDbValue($row["df" . $sfx]);
            }
        }

        // Render data
        $renderer->$fn();

        // Output data from ViewValue
        foreach ($this->DisplayFields as $index => $name) {
            $displayField = @$renderer->Fields[$name];
            if ($displayField) {
                $sfx = $index > 0 ? $index + 1 : "";
                $viewValue = $displayField->getViewValue();
                if (!EmptyString($viewValue)) { // Make sure that ViewValue is not empty
                    $row[$index + 1] = $viewValue;
                    $row["df" . $sfx] = $viewValue;
                }
            }
        }
        $this->rendering = false;
        return $row;
    }

    /**
     * Get table object
     *
     * @return object
     */
    public function getTable()
    {
        if ($this->LinkTable == "") {
            return null;
        }
        $this->Table = $this->Table ?? Container($this->LinkTable);
        return $this->Table;
    }

    /**
     * Check if filter operator is valid
     *
     * @param string $opr Operator, e.g. '<', '>'
     * @return bool
     */
    protected function isValidOperator($opr)
    {
        return in_array($opr, ['=', '<>', '<', '<=', '>', '>=', 'LIKE', 'NOT LIKE', 'STARTS WITH', 'ENDS WITH']);
    }

    /**
     * Get part of lookup SQL
     *
     * @param string $part Part of the SQL (select|where|orderby|"")
     * @param bool $isUser Whether the CurrentFilter, UserFilter and UserSelect properties should be used
     * @param bool $useParentFilter Use parent filter
     * @param bool $skipFilterFields Skip filter fields
     * @return string|QueryBuilder Part of SQL, or QueryBuilder if $part unspecified
     */
    protected function getSqlPart($part = "", $isUser = true, $useParentFilter = true, $skipFilterFields = false)
    {
        $tbl = $this->getTable();
        if ($tbl === null) {
            return "";
        }

        // Set up SELECT ... FROM ...
        $dbid = $tbl->Dbid;
        $queryBuilder = $tbl->getQueryBuilder();
        if ($this->Distinct) {
            $queryBuilder->distinct();
        }
        // Set up link field
        $linkField = @$tbl->Fields[$this->LinkField];
        if (!$linkField) {
            return "";
        }
        $select = $linkField->Expression;
        if ($this->LookupType != "unknown") { // Known lookup types
            $select .= " AS " . QuotedName("lf", $dbid);
        }
        $queryBuilder->select($select);
        // Set up lookup fields
        $lookupCnt = 0;
        if (SameText($this->LookupType, "autofill")) {
            if (is_array($this->AutoFillSourceFields)) {
                foreach ($this->AutoFillSourceFields as $i => $autoFillSourceField) {
                    $autoFillSourceField = @$tbl->Fields[$autoFillSourceField];
                    if (!$autoFillSourceField) {
                        $select = "'' AS " . QuotedName("af" . $i, $dbid);
                    } else {
                        $select = $autoFillSourceField->Expression . " AS " . QuotedName("af" . $i, $dbid);
                    }
                    $queryBuilder->addSelect($select);
                    if (!$autoFillSourceField->AutoFillOriginalValue) {
                        $this->FormatAutoFill = true;
                    }
                    $lookupCnt++;
                }
            }
        } else {
            if (is_array($this->DisplayFields)) {
                foreach ($this->DisplayFields as $i => $displayField) {
                    $displayField = @$tbl->Fields[$displayField];
                    if (!$displayField) {
                        $select = "'' AS " . QuotedName("df" . (($i == 0) ? "" : $i + 1), $dbid);
                    } else {
                        $select = $displayField->Expression;
                        if ($this->LookupType != "unknown") { // Known lookup types
                            $select .= " AS " . QuotedName("df" . (($i == 0) ? "" : $i + 1), $dbid);
                        }
                    }
                    $queryBuilder->addSelect($select);
                    $lookupCnt++;
                }
            }
            if (is_array($this->FilterFields) && !$useParentFilter && !$skipFilterFields) {
                $i = 0;
                foreach ($this->FilterFields as $filterField => $filterOpr) {
                    $filterField = @$tbl->Fields[$filterField];
                    if (!$filterField) {
                        $select = "'' AS " . QuotedName("ff" . (($i == 0) ? "" : $i + 1), $dbid);
                    } else {
                        $select = $filterField->Expression;
                        if ($this->LookupType != "unknown") { // Known lookup types
                            $select .= " AS " . QuotedName("ff" . (($i == 0) ? "" : $i + 1), $dbid);
                        }
                    }
                    $queryBuilder->addSelect($select);
                    $i++;
                    $lookupCnt++;
                }
            }
        }
        if ($lookupCnt == 0) {
            return "";
        }
        $queryBuilder->from($tbl->getSqlFrom());

        // User SELECT
        $select = "";
        if ($this->UserSelect != "" && $isUser) {
            $select = $this->UserSelect;
        }

        // Set up WHERE
        $where = "";

        // Set up user id filter
        if (method_exists($tbl, "applyUserIDFilters")) {
            $where = $tbl->applyUserIDFilters($where);
        }

        // Set up current filter
        $cnt = count($this->FilterValues);
        if ($cnt > 0) {
            $val = $this->FilterValues[0];
            if ($val != "") {
                $val = strval($val);
                AddFilter($where, $this->getFilter($linkField, "=", $val, $tbl->Dbid));
            }

            // Set up parent filters
            if (is_array($this->FilterFields) && $useParentFilter) {
                $i = 1;
                foreach ($this->FilterFields as $filterField => $filterOpr) {
                    if ($filterField != "") {
                        $filterField = @$tbl->Fields[$filterField];
                        if (!$filterField) {
                            return "";
                        }
                        if ($cnt <= $i) {
                            AddFilter($where, "1=0"); // Disallow
                        } else {
                            $val = strval($this->FilterValues[$i]);
                            AddFilter($where, $this->getFilter($filterField, $filterOpr, $val, $tbl->Dbid));
                        }
                    }
                    $i++;
                }
            }
        }

        // Set up search
        if ($this->SearchValue != "") {
            // Set up modal lookup search
            if (SameText($this->LookupType, "modal")) {
                $flds = [];
                foreach ($this->DisplayFields as $displayField) {
                    if ($displayField != "") {
                        $displayField = $tbl->Fields[$displayField];
                        $flds[] = $displayField->Expression;
                    }
                }
                AddFilter($where, $this->getModalSearchFilter($this->SearchValue, $flds));
            } elseif (SameText($this->LookupType, "autosuggest")) {
                if (Config("AUTO_SUGGEST_FOR_ALL_FIELDS")) {
                    $filter = "";
                    foreach ($this->DisplayFields as $displayField) {
                        if ($displayField != "") {
                            $displayField = $tbl->Fields[$displayField];
                            if ($filter != "") {
                                $filter .= " OR ";
                            }
                            $filter .= $this->getAutoSuggestFilter($this->SearchValue, $displayField);
                        }
                    }
                    AddFilter($where, $filter);
                } else {
                    $displayField = $tbl->Fields[$this->DisplayFields[0]];
                    AddFilter($where, $this->getAutoSuggestFilter($this->SearchValue, $displayField));
                }
            }
        }

        // Add filters
        if ($this->CurrentFilter != "" && $isUser) {
            AddFilter($where, $this->CurrentFilter);
        }

        // User Filter
        if ($this->UserFilter != "" && $isUser) {
            AddFilter($where, $this->UserFilter);
        }

        // Set up ORDER BY
        $orderBy = $this->UserOrderBy;

        // Return SQL part
        if ($part == "select") {
            return $select != "" ? $select : $queryBuilder->getSQL();
        } elseif ($part == "where") {
            return $where;
        } elseif ($part == "orderby") {
            return $orderBy;
        } else {
            if ($select != "") {
                $sql = $select;
                $dbType = GetConnectionType($tbl->Dbid);
                if ($where != "") {
                    $sql .= " WHERE " . $where;
                }
                if ($orderBy != "") {
                    if ($dbType == "MSSQL") {
                        $sql .= " /*BeginOrderBy*/ORDER BY " . $orderBy . "/*EndOrderBy*/";
                    } else {
                        $sql .= " ORDER BY " . $orderBy;
                    }
                }
                return $sql;
            } else {
                if ($where != "") {
                    $queryBuilder->where($where);
                }
                $flds = GetSortFields($orderBy);
                if (is_array($flds)) {
                    foreach ($flds as $fld) {
                        $queryBuilder->addOrderBy($fld[0], $fld[1]);
                    }
                }
                return $queryBuilder;
            }
        }
    }

    /**
     * Get filter
     *
     * @param object $fld Field Object
     * @param string $opr Search Operator
     * @param string $val Search Value
     * @param string $dbid Database Id
     * @return string Search Filter (SQL WHERE part)
     */
    protected function getFilter($fld, $opr, $val, $dbid)
    {
        $validValue = $val != "";
        $where = "";
        $arVal = explode(Config("MULTIPLE_OPTION_SEPARATOR"), $val);
        if ($fld->DataType == DATATYPE_NUMBER) { // Validate numeric fields
            foreach ($arVal as $val) {
                if (!is_numeric($val)) {
                    $validValue = false;
                }
            }
        }
        if ($validValue) {
            if ($opr == "=") { // Use the IN operator
                foreach ($arVal as &$val) {
                    $val = QuotedValue($val, $fld->DataType, $dbid);
                }
                $where = $fld->Expression . " IN (" . implode(", ", $arVal) . ")";
            } else { // Custom operator
                foreach ($arVal as $val) {
                    if (in_array($opr, ['LIKE', 'NOT LIKE', 'STARTS WITH', 'ENDS WITH'])) {
                        if ($opr == 'STARTS WITH') {
                            $val .= '%';
                        } elseif ($opr == 'ENDS WITH') {
                            $val = '%' . $val;
                        } else {
                            $val = '%' . $val . '%';
                        }
                        $fldOpr = ($opr == 'NOT LIKE') ? ' NOT LIKE ' : ' LIKE ';
                        $val = QuotedValue($val, DATATYPE_STRING, $dbid);
                    } else {
                        $fldOpr = $opr;
                        $val = QuotedValue($val, $fld->DataType, $dbid);
                    }
                    if ($where != "") {
                        $where .= " OR ";
                    }
                    $where .= $fld->Expression . $fldOpr . $val;
                }
            }
        } else {
            $where = "1=0"; // Disallow
        }
        return $where;
    }

    /**
     * Get user filter
     *
     * @return string
     */
    protected function getUserFilter($useParentFilter = false)
    {
        return $this->getSqlPart("where", false, $useParentFilter);
    }

    /**
     * Execute query
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder of the SQL to be executed
     * @param string $orderBy ORDER BY clause
     * @param int $pageSize
     * @param int $offset
     * @return ResultStatement
     */
    protected function executeQuery($sql, $orderBy, $pageSize, $offset)
    {
        $tbl = $this->getTable();
        if ($tbl === null) {
            return null;
        }
        if ($sql instanceof \Doctrine\DBAL\Query\QueryBuilder) { // Query builder
            if ($offset > -1) {
                $sql->setFirstResult($offset);
            }
            if ($pageSize > 0) {
                $sql->setMaxResults($pageSize);
            }
            return $sql->execute();
        } else {
            $conn = $tbl->getConnection();
            return $conn->executeQuery($sql);
        }
    }

    /**
     * Get auto suggest filter
     *
     * @param string $sv Search value
     * @param object $fld Field object
     * @return string
     */
    protected function getAutoSuggestFilter($sv, $fld)
    {
        if (Config("AUTO_SUGGEST_FOR_ALL_FIELDS")) {
            return $this->getCastFieldForLike($fld) . Like(QuotedValue("%" . $sv . "%", DATATYPE_STRING, $this->Table->Dbid));
        } else {
            return $this->getCastFieldForLike($fld) . Like(QuotedValue($sv . "%", DATATYPE_STRING, $this->Table->Dbid));
        }
    }

    /**
     * Get Cast SQL for LIKE operator
     *
     * @param object $fld Field object
     * @return string
     */
    protected function getCastFieldForLike($fld)
    {
        $expr = $fld->Expression;
        // Date/Time field
        if ($fld->DataType == DATATYPE_DATE || $fld->DataType == DATATYPE_TIME) {
            return CastDateFieldForLike($expr, $fld->DateTimeFormat, $this->Table->Dbid);
        }
        $dbType = GetConnectionType($this->Table->Dbid);
        if ($fld->DataType == DATATYPE_NUMBER && $dbType == "MSSQL") {
            return "CAST(" . $expr . " AS NVARCHAR)";
        }
        if ($fld->DataType != DATATYPE_STRING && $dbType == "POSTGRESQL") {
            return "CAST(" . $expr . " AS varchar(255))";
        }
        return $expr;
    }

    /**
     * Get modal search filter
     *
     * @param string $sv Search value
     * @param array $flds Field expressions
     * @return string
     */
    protected function getModalSearchFilter($sv, $flds)
    {
        if (EmptyString($sv)) {
            return "";
        }
        $searchStr = "";
        $search = trim($sv);
        $searchType = $this->ModalLookupSearchType;
        if ($searchType != "=") {
            $ar = [];

            // Match quoted keywords (i.e.: "...")
            if (preg_match_all('/"([^"]*)"/i', $search, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $p = strpos($search, $match[0]);
                    $str = substr($search, 0, $p);
                    $search = substr($search, $p + strlen($match[0]));
                    if (strlen(trim($str)) > 0) {
                        $ar = array_merge($ar, explode(" ", trim($str)));
                    }
                    $ar[] = $match[1]; // Save quoted keyword
                }
            }

            // Match individual keywords
            if (strlen(trim($search)) > 0) {
                $ar = array_merge($ar, explode(" ", trim($search)));
            }

            // Search keyword in any fields
            if ($searchType == "OR" || $searchType == "AND") {
                foreach ($ar as $keyword) {
                    if ($keyword != "") {
                        $searchFilter = $this->getModalSearchSql([$keyword], $flds);
                        if ($searchFilter != "") {
                            if ($searchStr != "") {
                                $searchStr .= " " . $searchType . " ";
                            }
                            $searchStr .= "(" . $searchFilter . ")";
                        }
                    }
                }
            } else {
                $searchStr = $this->getModalSearchSql($ar, $flds);
            }
        } else {
            $searchStr = $this->getModalSearchSql([$search], $flds);
        }
        return $searchStr;
    }

    /**
     * Get modal search SQL
     *
     * @param array $keywords Keywords
     * @param array $flds Field expressions
     * @return string
     */
    protected function getModalSearchSql($keywords, $flds)
    {
        $where = "";
        if (is_array($flds)) {
            foreach ($flds as $fldExpr) {
                if ($fldExpr != "") {
                    $this->buildModalSearchSql($where, $fldExpr, $keywords);
                }
            }
        }
        return $where;
    }

    /**
     * Build and set up modal search SQL
     *
     * @param string &$where WHERE clause
     * @param string $fldExpr Field expression
     * @param array $keywords Keywords
     * @return void
     */
    protected function buildModalSearchSql(&$where, $fldExpr, $keywords)
    {
        $searchType = $this->ModalLookupSearchType;
        $defCond = ($searchType == "OR") ? "OR" : "AND";
        $arSql = []; // Array for SQL parts
        $arCond = []; // Array for search conditions
        $cnt = count($keywords);
        $j = 0; // Number of SQL parts
        for ($i = 0; $i < $cnt; $i++) {
            $keyword = $keywords[$i];
            $keyword = trim($keyword);
            if (Config("BASIC_SEARCH_IGNORE_PATTERN") != "") {
                $keyword = preg_replace(Config("BASIC_SEARCH_IGNORE_PATTERN"), "\\", $keyword);
                $arwrk = explode("\\", $keyword);
            } else {
                $arwrk = [$keyword];
            }
            foreach ($arwrk as $keyword) {
                if ($keyword != "") {
                    $wrk = "";
                    if ($keyword == "OR" && $searchType == "") {
                        if ($j > 0) {
                            $arCond[$j - 1] = "OR";
                        }
                    } else {
                        $wrk = $fldExpr . Like(QuotedValue("%" . $keyword . "%", DATATYPE_STRING, $this->Table->Dbid), $this->Table->Dbid);
                    }
                    if ($wrk != "") {
                        $arSql[$j] = $wrk;
                        $arCond[$j] = $defCond;
                        $j += 1;
                    }
                }
            }
        }
        $cnt = count($arSql);
        $quoted = false;
        $sql = "";
        if ($cnt > 0) {
            for ($i = 0; $i < $cnt - 1; $i++) {
                if ($arCond[$i] == "OR") {
                    if (!$quoted) {
                        $sql .= "(";
                    }
                    $quoted = true;
                }
                $sql .= $arSql[$i];
                if ($quoted && $arCond[$i] != "OR") {
                    $sql .= ")";
                    $quoted = false;
                }
                $sql .= " " . $arCond[$i] . " ";
            }
            $sql .= $arSql[$cnt - 1];
            if ($quoted) {
                $sql .= ")";
            }
        }
        if ($sql != "") {
            if ($where != "") {
                $where .= " OR ";
            }
            $where .= "(" . $sql . ")";
        }
    }

    /**
     * Format options
     *
     * @param array $options Input options with formats:
     *  1. Manual input data, e.g.: [ ["lv1", "dv", "dv2", "dv3", "dv4"], ["lv2", "dv", "dv2", "dv3", "dv4"], etc...]
     *  2. Data from $rs->getRows(), e.g.: [ [0 => "lv1", "Field1" => "lv1", 1 => "dv", "Field2" => "dv2", ...], [0 => "lv2", "Field1" => "lv2", 1 => "dv", "Field2" => "dv2", ...], etc...]
     * @return array ["lv1" => [0 => "lv1", "lf" => "lv1", 1 => "dv", "df" => "dv", etc...], etc...]
     */
    protected function formatOptions($options)
    {
        if (!is_array($options)) {
            return null;
        }
        $keys = [0, 1, 2, 3, 4, 5, 6, 7, 8];
        $keys2 = ["lf", "df", "df2", "df3", "df4", "ff", "ff2", "ff3", "ff4"];
        $opts = [];
        $cnt = count($keys);

        // Check values and remove non-numeric keys
        foreach ($options as &$ar) {
            if (is_array($ar)) {
                // Remove non-numeric keys first
                $ar = array_intersect_key($ar, array_flip(array_filter(array_keys($ar), 'is_numeric')));
                if ($cnt > count($ar)) {
                    $cnt = count($ar);
                }
            }
        }

        // Set up options
        if ($cnt >= 2) {
            $keys = array_splice($keys, 0, $cnt);
            $keys2 = array_splice($keys2, 0, $cnt);
            foreach ($options as &$ar) {
                if (is_array($ar)) {
                    $ar = array_splice($ar, 0, $cnt);
                    $ar = array_merge(array_combine($keys, $ar), array_combine($keys2, $ar)); // Set keys
                    $lv = $ar[0]; // First value as link value
                    $opts[$lv] = $ar;
                }
            }
        } else {
            return null;
        }
        return $opts;
    }
}
