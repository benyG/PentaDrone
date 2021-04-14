<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Table classes
 */
// Common class for table and report
class DbTableBase
{
    public $TableVar;
    public $TableName;
    public $TableType;
    public $Dbid = "DB"; // Table database id
    public $Visible = true;
    public $Fields = [];
    public $Rows = []; // Data for Custom Template
    public $OldKey = ""; // Old key (for edit/copy)
    public $OldKeyName = "k_oldkey"; // Old key name (for edit/copy)
    public $Recordset = null; // Recordset
    public $UseTokenInUrl;
    public $UseCustomTemplate = false; // Use custom template
    public $Export; // Export
    public $CustomExport; // Custom export
    public $ExportAll;
    public $ExportPageBreakCount; // Page break per every n record (PDF only)
    public $ExportPageOrientation; // Page orientation (PDF only)
    public $ExportPageSize; // Page size (PDF only)
    public $ExportExcelPageOrientation; // Page orientation (Excel only)
    public $ExportExcelPageSize; // Page size (Excel only)
    public $ExportWordPageOrientation; // Page orientation (Word only)
    public $ExportWordColumnWidth; // Page orientation (Word only)
    public $SendEmail; // Send email
    public $ImportCsvEncoding = ""; // Import to CSV encoding
    public $ImportCsvDelimiter; // Import to CSV delimiter
    public $ImportCsvQuoteCharacter; // Import to CSV quote character
    public $ImportMaxExecutionTime; // Import max execution time
    public $ImportInsertOnly; // Import by insert only
    public $ImportUseTransaction; // Import use transaction
    public $BasicSearch; // Basic search
    public $CurrentFilter; // Current filter
    public $CurrentOrder; // Current order
    public $CurrentOrderType; // Current order type
    public $RowCount = 0;
    public $RowType; // Row type
    public $CssClass; // CSS class
    public $CssStyle; // CSS style
    public $RowAttrs; // Row custom attributes
    public $CurrentAction; // Current action
    public $LastAction; // Last action
    public $UserIDAllowSecurity = 0; // User ID allowed permissions
    public $Count = 0; // Record count (as detail table)
    public $UpdateTable = ""; // Update Table
    public $Filter = "";
    public $DefaultFilter = "";
    public $Sort = "";
    public $DefaultSort = "";
    public $Pager;
    public $AutoHidePager;
    public $AutoHidePageSizeSelector;
    public $QueryBuilder;
    protected $TableCaption = "";
    protected $PageCaption = [];

    // Constructor
    public function __construct()
    {
        $this->UseTokenInUrl = Config("USE_TOKEN_IN_URL");
        $this->ImportCsvDelimiter = Config("IMPORT_CSV_DELIMITER");
        $this->ImportCsvQuoteCharacter = Config("IMPORT_CSV_QUOTE_CHARACTER");
        $this->ImportMaxExecutionTime = Config("IMPORT_MAX_EXECUTION_TIME");
        $this->ImportInsertOnly = Config("IMPORT_INSERT_ONLY");
        $this->ImportUseTransaction = Config("IMPORT_USE_TRANSACTION");
        $this->AutoHidePager = Config("AUTO_HIDE_PAGER");
        $this->AutoHidePageSizeSelector = Config("AUTO_HIDE_PAGE_SIZE_SELECTOR");
        $this->RowAttrs = new Attributes();
    }

    // Get Connection
    public function getConnection()
    {
        $conn = Conn($this->Dbid);
        return $conn;
    }

    // Get query builder
    public function getQueryBuilder()
    {
        $conn = $this->getConnection();
        return $conn->createQueryBuilder();
    }

    /**
     * Build SELECT statement
     *
     * @param string $select
     * @param string $from
     * @param string $where
     * @param string $groupBy
     * @param string $having
     * @param string $orderBy
     * @param string $filter
     * @param string $sort
     * @return QueryBuilder
     */
    public function buildSelectSql($select, $from, $where, $groupBy, $having, $orderBy, $filter, $sort)
    {
        if (is_string($select)) {
            $queryBuilder = $this->getQueryBuilder();
            $queryBuilder->select($select);
        } elseif ($select instanceof \Doctrine\DBAL\Query\QueryBuilder) {
            $queryBuilder = $select;
        }
        if ($from != "") {
            $queryBuilder->from($from);
        }
        if ($where != "") {
            $queryBuilder->where($where);
        }
        if ($filter != "") {
            $queryBuilder->andWhere($filter);
        }
        if ($groupBy != "") {
            $queryBuilder->groupBy($groupBy);
        }
        if ($having != "") {
            $queryBuilder->having($having);
        }
        if ($sort != "") {
            $orderBy = $sort;
        }
        $flds = GetSortFields($orderBy);
        if (is_array($flds)) {
            foreach ($flds as $fld) {
                $queryBuilder->addOrderBy($fld[0], $fld[1]);
            }
        }
        return $queryBuilder;
    }

    // Build filter from array
    protected function arrayToFilter(&$ar)
    {
        $filter = "";
        foreach ($ar as $name => $value) {
            if (array_key_exists($name, $this->Fields)) {
                AddFilter($filter, QuotedName($this->Fields[$name]->Name, $this->Dbid) . '=' . QuotedValue($value, $this->Fields[$name]->DataType, $this->Dbid));
            }
        }
        return $filter;
    }

    // Reset attributes for table object
    public function resetAttributes()
    {
        $this->CssClass = "";
        $this->CssStyle = "";
        $this->RowAttrs = new Attributes();
        foreach ($this->Fields as $fld) {
            $fld->resetAttributes();
        }
    }

    // Setup field titles
    public function setupFieldTitles()
    {
        foreach ($this->Fields as $fld) {
            if (strval($fld->title()) != "") {
                $fld->EditAttrs["data-toggle"] = "tooltip";
                $fld->EditAttrs["title"] = HtmlEncode($fld->title());
            }
        }
    }

    // Get field values
    public function getFieldValues($propertyname)
    {
        $values = [];
        foreach ($this->Fields as $fldname => $fld) {
            $values[$fldname] = $fld->$propertyname;
        }
        return $values;
    }

    // Get field cell attributes
    public function fieldCellAttributes()
    {
        $values = [];
        foreach ($this->Fields as $fldname => $fld) {
            $values[$fld->Param] = $fld->cellAttributes();
        }
        return $values;
    }

    // Get field DB values for Custom Template
    public function customTemplateFieldValues()
    {
        $values = [];
        foreach ($this->Fields as $fldname => $fld) {
            if (in_array($fld->DataType, Config("CUSTOM_TEMPLATE_DATATYPES")) && $fld->Visible) {
                if (is_string($fld->DbValue) && strlen($fld->DbValue) > Config("DATA_STRING_MAX_LENGTH")) {
                    $values[$fld->Param] = substr($fld->DbValue, 0, Config("DATA_STRING_MAX_LENGTH"));
                } else {
                    $values[$fld->Param] = $fld->DbValue;
                }
            }
        }
        return $values;
    }

    // Set table caption
    public function setTableCaption($v)
    {
        $this->TableCaption = $v;
    }

    // Table caption
    public function tableCaption()
    {
        global $Language;
        if ($this->TableCaption == "") {
            $this->TableCaption = $Language->TablePhrase($this->TableVar, "TblCaption");
        }
        return $this->TableCaption;
    }

    // Set page caption
    public function setPageCaption($page, $v)
    {
        $this->PageCaption[$page] = $v;
    }

    // Page caption
    public function pageCaption($page)
    {
        global $Language;
        $caption = @$this->PageCaption[$page];
        if ($caption != "") {
            return $caption;
        } else {
            $caption = $Language->tablePhrase($this->TableVar, "TblPageCaption" . $page);
            if ($caption == "") {
                $caption = "Page " . $page;
            }
            return $caption;
        }
    }

    // Add URL parameter
    public function getUrlParm($parm = "")
    {
        $urlParm = ($this->UseTokenInUrl) ? "t=" . $this->TableVar : "";
        if ($parm != "") {
            if ($urlParm != "") {
                $urlParm .= "&";
            }
            $urlParm .= $parm;
        }
        return $urlParm;
    }

    // Row styles
    public function rowStyles()
    {
        $att = "";
        $style = Concat($this->CssStyle, $this->RowAttrs["style"], ";");
        $class = $this->CssClass;
        AppendClass($class, $this->RowAttrs["class"]);
        if ($style != "") {
            $att .= ' style="' . $style . '"';
        }
        if ($class != '') {
            $att .= ' class="' . $class . '"';
        }
        return $att;
    }

    // Row attributes
    public function rowAttributes()
    {
        $att = $this->rowStyles();
        if (!$this->isExport()) {
            $attrs = $this->RowAttrs->toString(["class", "style"]);
            if ($attrs != "") {
                $att .= $attrs;
            }
        }
        return $att;
    }

    // Field object by name
    public function fields($fldname)
    {
        return $this->Fields[$fldname];
    }

    // Has Invalid fields
    public function hasInvalidFields()
    {
        foreach ($this->Fields as $fldname => $fld) {
            if ($fld->IsInvalid) {
                return true;
            }
        }
        return false;
    }

    // Export
    public function isExport($format = "")
    {
        if ($format) {
            return SameText($this->Export, $format);
        } else {
            return $this->Export != "";
        }
    }

    /**
     * Set use lookup cache
     *
     * @param bool $b Use lookup cache or not
     * @return void
     */
    public function setUseLookupCache($b)
    {
        foreach ($this->Fields as $fld) {
            $fld->UseLookupCache = $b;
        }
    }

    /**
     * Set Lookup cache count
     *
     * @param int $i Lookup cache count
     * @return void
     */
    public function setLookupCacheCount($i)
    {
        foreach ($this->Fields as $fld) {
            $fld->LookupCacheCount = $i;
        }
    }

    /**
     * Convert properties to client side variables
     *
     * @param string[] $tablePropertyNames Table property names
     * @param string[] $fieldPropertyNames Field property names
     * @return void
     */
    public function toClientVar($tablePropertyNames, $fieldPropertyNames = [])
    {
        $props = [];
        foreach ($tablePropertyNames as $name) {
            if (method_exists($this, $name)) {
                $props[lcfirst($name)] = $this->$name();
            } elseif (property_exists($this, $name)) {
                $props[lcfirst($name)] = $this->$name;
            }
        }
        if (count($fieldPropertyNames) > 0) {
            $props["fields"] = [];
            foreach ($this->Fields as $fld) {
                $props["fields"][$fld->Param] = [];
                foreach ($fieldPropertyNames as $name) {
                    if (method_exists($fld, $name)) {
                        $props["fields"][$fld->Param][lcfirst($name)] = $fld->$name();
                    } elseif (property_exists($fld, $name)) {
                        $props["fields"][$fld->Param][lcfirst($name)] = $fld->$name;
                    }
                };
            }
        }
        SetClientVar("tables", [$this->TableVar => $props]);
    }

    // For obsolete properties only
    public function __set($name, $value)
    {
        if (EndsString("_Count", $name)) { // <DetailTable>_Count
            $t = preg_replace('/_Count$/', "", $name);
            trigger_error("Obsolete property: " . $name . ", please use Container('" . $t . "')->Count.", E_USER_ERROR);
        } elseif (Config("DEBUG")) {
            trigger_error("Undefined property: " . $name . ".", E_USER_ERROR);
        }
    }

    // For obsolete properties only
    public function __get($name)
    {
        if (EndsString("_Count", $name)) { // <DetailTable>_Count
            $t = preg_replace('/_Count$/', "", $name);
            trigger_error("Obsolete property: " . $name . ", please use Container('" . $t . "')->Count.", E_USER_ERROR);
        } elseif (Config("DEBUG")) {
            trigger_error("Undefined property: " . $name . ".", E_USER_ERROR);
        }
        return null;
    }
}
