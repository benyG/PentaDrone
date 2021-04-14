<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Report table class
 */
class ReportTable extends DbTableBase
{
    public $ReportSourceTable;
    public $TableReportType;
    public $SourceTableIsCustomView = false;
    public $ShowCurrentFilter;
    public $ShowDrillDownFilter;
    public $UseDrillDownPanel; // Use drill down panel
    public $DrillDown = false;
    public $DrillDownInPanel = false;
    public $ExportChartPageBreak = true; // Page break for chart when export
    public $PageBreakContent;
    public $RowTotalType; // Row total type
    public $RowTotalSubType; // Row total subtype
    public $RowGroupLevel; // Row group level

    // Constructor
    public function __construct()
    {
        parent::__construct();
        $this->ShowCurrentFilter = Config("SHOW_CURRENT_FILTER");
        $this->ShowDrillDownFilter = Config("SHOW_DRILLDOWN_FILTER");
        $this->UseDrillDownPanel = Config("USE_DRILLDOWN_PANEL");
        $this->PageBreakContent = Config("PAGE_BREAK_HTML");
    }

    // Session Group Per Page
    public function getGroupPerPage()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_grpperpage");
    }

    public function setGroupPerPage($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_grpperpage"] = $v;
    }

    // Session Start Group
    public function getStartGroup()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_start");
    }

    public function setStartGroup($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_start"] = $v;
    }

    // Session Order By
    public function getOrderBy()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_orderby");
    }

    public function setOrderBy($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_orderby"] = $v;
    }

    // Session Order By (for non-grouping fields)
    public function getDetailOrderBy()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_detailorderby");
    }

    public function setDetailOrderBy($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_detailorderby"] = $v;
    }

    // Reset attributes for table object
    public function resetAttributes()
    {
        $this->RowAttrs = new Attributes();
        foreach ($this->Fields as $fld) {
            $fld->resetAttributes();
        }
    }

    // URL encode
    public function urlEncode($str)
    {
        return urlencode($str);
    }

    // Print
    public function raw($str)
    {
        return $str;
    }

    /**
     * Build Report SQL
     *
     * @param string|QueryBuilder $select
     * @param string $from
     * @param string $where
     * @param string $groupBy
     * @param string $having
     * @param string $orderBy
     * @param string $filter
     * @param string $sort
     * @return QueryBuilder
     */
    public function buildReportSql($select, $from, $where, $groupBy, $having, $orderBy, $filter, $sort)
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
        $flds = UpdateSortFields($orderBy, $sort, 1);
        if (is_array($flds)) {
            foreach ($flds as $fld) {
                $queryBuilder->addOrderBy($fld[0], $fld[1]);
            }
        }
        return $queryBuilder;
    }
}
