<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Chart class
 */
class DbChart
{
    public $Table; // Table object
    public $TableVar; // Retained for compatibility
    public $TableName; // Retained for compatibility
    public $Name; // Chart name
    public $ChartVar; // Chart variable name
    public $XFieldName; // Chart X Field name
    public $YFieldName; // Chart Y Field name
    public $Type; // Chart Type
    public $SeriesFieldName; // Chart Series Field name
    public $SeriesType; // Chart Series Type
    public $SeriesRenderAs = ""; // Chart Series renderAs
    public $SeriesYAxis = ""; // Chart Series Y Axis
    public $RunTimeSort = false; // Chart run time sort
    public $SortType = 0; // Chart Sort Type
    public $SortSequence = ""; // Chart Sort Sequence
    public $SummaryType; // Chart Summary Type
    public $Width; // Chart Width
    public $Height; // Chart Height
    public $Align; // Chart Align
    public $DrillDownTable = ""; // Chart drill down table name
    public $DrillDownUrl = ""; // Chart drill down URL
    public $UseDrillDownPanel; // Use drill down panel
    public $DefaultDecimalPrecision;
    public $SqlSelect;
    public $SqlWhere = "";
    public $SqlGroupBy;
    public $SqlOrderBy;
    public $XAxisDateFormat;
    public $NameDateFormat;
    public $SeriesDateType;
    public $SqlSelectSeries;
    public $SqlWhereSeries = "";
    public $SqlGroupBySeries;
    public $SqlOrderBySeries;
    public $ChartSeriesSql;
    public $ChartSql;
    public $PageBreak = true; // Page break before/after chart
    public $PageBreakType = "before"; // "before" or "after"
    public $PageBreakContent; // Page break HTML
    public $DrillDownInPanel = false;
    public $ScrollChart = false;
    public $IsCustomTemplate = false;
    public $ID;
    public $Parameters;
    public $Trends;
    public $Data;
    public $ViewData;
    public $Series;
    public $Caption = "";
    public $DataFormat = "json";
    public $ScaleBeginWithZero;
    public $MinValue = null;
    public $MaxValue = null;
    protected $dataLoaded = false;

    // Constructor
    public function __construct(&$tbl, $chartvar, $chartname, $xfld, $yfld, $type, $sfld, $stype, $smrytype, $width, $height, $align = "")
    {
        $this->UseDrillDownPanel = Config("USE_DRILLDOWN_PANEL");
        $this->DefaultDecimalPrecision = Config("DEFAULT_DECIMAL_PRECISION");
        $this->PageBreakContent = Config("PAGE_BREAK_HTML");
        $this->Table = &$tbl;
        $this->TableVar = $tbl->TableVar; // For compatibility
        $this->TableName = $tbl->TableName; // For compatibility
        $this->ChartVar = $chartvar;
        $this->Name = $chartname;
        $this->XFieldName = $xfld;
        $this->YFieldName = $yfld;
        $this->Type = $type;
        $this->SeriesFieldName = $sfld;
        $this->SeriesType = $stype;
        $this->SummaryType = $smrytype;
        $this->Width = $width;
        $this->Height = $height;
        $this->Align = $align;
        $this->ID = null;
        $this->Trends = null;
        $this->Data = null;
        $this->Series = null;
        $this->ScaleBeginWithZero = Config("CHART_SCALE_BEGIN_WITH_ZERO");
        if (Config("CHART_SCALE_MINIMUM_VALUE") !== 0) {
            $this->MinValue = Config("CHART_SCALE_MINIMUM_VALUE");
        }
        if (Config("CHART_SCALE_MAXIMUM_VALUE") !== 0) {
            $this->MaxValue = Config("CHART_SCALE_MAXIMUM_VALUE");
        }
        $this->Parameters = new \Dflydev\DotAccessData\Data();
    }

    // Set chart caption
    public function setCaption($v)
    {
        $this->Caption = $v;
    }

    // Chart caption
    public function caption()
    {
        global $Language;
        if ($this->Caption != "") {
            return $this->Caption;
        } else {
            return $Language->chartPhrase($this->Table->TableVar, $this->ChartVar, "ChartCaption");
        }
    }

    // X axis name
    public function xAxisName()
    {
        global $Language;
        return $Language->chartPhrase($this->Table->TableVar, $this->ChartVar, "ChartXAxisName");
    }

    // Y axis name
    public function yAxisName()
    {
        global $Language;
        return $Language->chartPhrase($this->Table->TableVar, $this->ChartVar, "ChartYAxisName");
    }

    // Primary axis name
    public function primaryYAxisName()
    {
        global $Language;
        return $Language->chartPhrase($this->Table->TableVar, $this->ChartVar, "ChartPYAxisName");
    }

    // Function SYAxisName
    public function secondaryYAxisName()
    {
        global $Language;
        return $Language->chartPhrase($this->Table->TableVar, $this->ChartVar, "ChartSYAxisName");
    }

    // Sort
    public function getSort()
    {
        return Session(PROJECT_NAME . "_" . $this->Table->TableVar . "_" . Config("TABLE_SORTCHART") . "_" . $this->ChartVar);
    }

    public function setSort($v)
    {
        if (Session(PROJECT_NAME . "_" . $this->Table->TableVar . "_" . Config("TABLE_SORTCHART") . "_" . $this->ChartVar) != $v) {
            $_SESSION[PROJECT_NAME . "_" . $this->Table->TableVar . "_" . Config("TABLE_SORTCHART") . "_" . $this->ChartVar] = $v;
        }
    }

    /**
     * Get chart parameters as array
     *
     * @param string $key Parameter name
     * @return array
     */
    public function getParameters($key)
    {
        return $this->Parameters->get($key) ?: [];
    }

    /**
     * Set chart parameters
     *
     * @param string $key Parameter name
     * @param mixed $value Parameter value
     * @param bool $output Obsolete. For backward compatibility only.
     * @return void
     */
    public function setParameter($key, $value, $output = true)
    {
        $this->Parameters->set($key, $value);
    }

    // Set chart parameters
    public function setParameters($parms)
    {
        if (is_array($parms)) {
            foreach ($parms as $parm) {
                if (is_array($parm) && count($parm) > 1) {
                    $this->Parameters->set($parm[0], $parm[1]);
                }
            }
        }
    }

    // Set up default chart parameter
    public function setDefaultParameter($key, $value)
    {
        $parm = $this->loadParameter($key);
        if ($parm === null) {
            $this->saveParameter($key, $value);
        }
    }

    // Load chart parameter
    public function loadParameter($key)
    {
        return $this->Parameters->get($key);
    }

    // Save chart parameter
    public function saveParameter($key, $value)
    {
        $this->Parameters->set($key, $value);
    }

    // Load chart parameters
    public function loadParameters()
    {
        // Initialize default values
        $this->setDefaultParameter("caption", "Chart");

        // Show names/values/hover
        $this->setDefaultParameter("shownames", "1"); // Default show names
        $this->setDefaultParameter("showvalues", "1"); // Default show values

        // Get showvalues/showhovercap
        $showValues = (bool)$this->loadParameter("showvalues");
        $showHoverCap = (bool)$this->loadParameter("showhovercap") || (bool)$this->loadParameter("showToolTip");

        // Show tooltip
        if ($showHoverCap && !$this->loadParameter("showToolTip")) {
            $this->saveParameter("showToolTip", "1");
        }

        // Format percent/number for Pie/Doughnut chart
        $showPercentageValues = $this->loadParameter("showPercentageValues");
        $showPercentageInLabel = $this->loadParameter("showPercentageInLabel");
        if ($this->isPieChart() || $this->isDoughnutChart()) {
            if ($showHoverCap == "1" && $showPercentageValues == "1" || $showValues == "1" && $showPercentageInLabel == "1") {
                $this->setDefaultParameter("formatNumber", "1");
                $this->saveParameter("formatNumber", "1");
            }
        }

        // Hide legend for single series (Column/Line/Area 2D)
        if ($this->ScrollChart && $this->isSingleSeries()) {
            $this->setDefaultParameter("showLegend", "0");
            $this->saveParameter("showLegend", "0");
        }
    }

    // Load view data
    public function loadViewData()
    {
        $sdt = $this->SeriesDateType;
        $xdt = $this->XAxisDateFormat;
        $ndt = ""; // Not used
        if ($sdt != "") {
            $xdt = $sdt;
        }
        $this->ViewData = [];
        if ($sdt == "" && $xdt == "" && $ndt == "") { // Format Y values
            $cntData = is_array($this->Data) ? count($this->Data) : 0;
            for ($i = 0; $i < $cntData; $i++) {
                $temp = [];
                $chartrow = $this->Data[$i];
                $cntRow = count($chartrow);
                $cntY = $this->SeriesType == 1 && count($this->Series) > 0 ? count($this->Series) : 1;
                for ($j = 0; $j < $cntRow; $j++) {
                    if ($j >= $cntRow - $cntY) {
                        $temp[$j] = $this->formatNumber($chartrow[$j]); // Y values
                    } else {
                        $temp[$j] = $chartrow[$j];
                    }
                }
                $this->ViewData[] = $temp;
            }
        } elseif (is_array($this->Data)) { // Format data
            $cntData = count($this->Data);
            for ($i = 0; $i < $cntData; $i++) {
                $temp = [];
                $chartrow = $this->Data[$i];
                $cntRow = count($chartrow);
                $temp[0] = $this->getXValue($chartrow[0], $xdt); // X value
                $temp[1] = $this->seriesValue($chartrow[1], $sdt); // Series value
                for ($j = 2; $j < $cntRow; $j++) {
                    if ($ndt != "" && $j == $cntRow - 1) {
                        $temp[$j] = $this->getXValue($chartrow[$j], $ndt); // Name value
                    } else {
                        $temp[$j] = $this->formatNumber($chartrow[$j]); // Y values
                    }
                }
                $this->ViewData[] = $temp;
            }
        }
    }

    // Set up chart
    public function setupChart()
    {
        global $DashboardReport, $ExportType, $Page;

        // Set up chart base SQL
        if ($this->Table->TableReportType == "crosstab") { // Crosstab chart
            $sqlSelect = $this->Table->getSqlSelect()->addSelect($this->Table->DistinctColumnFields);
            $sqlChartSelect = $this->SqlSelect;
        } else {
            $sqlSelect = $this->Table->getSqlSelect();
            $sqlChartSelect = $this->SqlSelect;
        }
        $pageFilter = !$DashboardReport && isset($Page) ? $Page->Filter : "";
        $dbType = GetConnectionType($this->Table->Dbid);
        if ($this->Table->SourceTableIsCustomView) {
            $sqlChartBase = "(" . $this->buildReportSql($sqlSelect, $this->Table->getSqlFrom(), $this->Table->getSqlWhere(), $this->Table->getSqlGroupBy(), $this->Table->getSqlHaving(), ($dbType == "MSSQL") ? $this->Table->getSqlOrderBy() : "", $pageFilter, "")->getSQL() . ") TMP_TABLE";
        } else {
            $sqlChartBase = $this->Table->getSqlFrom();
        }

        // Set up chart series
        if (!EmptyString($this->SeriesFieldName)) {
            if ($this->SeriesType == 1) { // Multiple Y fields
                $ar = explode("|", $this->SeriesFieldName);
                $cnt = count($ar);
                $yaxis = explode(",", $this->SeriesYAxis);
                for ($i = 0; $i < $cnt; $i++) {
                    $fld = &$this->Table->Fields[$ar[$i]];
                    if (StartsString("4", strval($this->Type))) { // Combination charts
                        $series = @$yaxis[$i] == "2" ? "S" : "P";
                        $this->Series[] = [$fld->caption(), $series];
                    } else {
                        $this->Series[] = $fld->caption();
                    }
                }
            } elseif ($this->Table->TableReportType == "crosstab" && $this->SeriesFieldName == $this->Table->ColumnFieldName && $this->Table->ColumnDateSelection && $this->Table->ColumnDateType == "q") { // Quarter
                for ($i = 1; $i <= 4; $i++) {
                    $this->Series[] = QuarterName($i);
                }
            } elseif ($this->Table->TableReportType == "crosstab" && $this->SeriesFieldName == $this->Table->ColumnFieldName && $this->Table->ColumnDateSelection && $this->Table->ColumnDateType == "m") { // Month
                for ($i = 1; $i <= 12; $i++) {
                    $this->Series[] = MonthName($i);
                }
            } else { // Load chart series from SQL directly
                if ($this->Table->SourceTableIsCustomView) {
                    $sql = $this->buildReportSql($this->SqlSelectSeries, $sqlChartBase, $this->SqlWhereSeries, $this->SqlGroupBySeries, "", $this->SqlOrderBySeries, "", "");
                } else {
                    $chartFilter = $this->SqlWhereSeries;
                    AddFilter($chartFilter, $this->Table->getSqlWhere());
                    $sql = $this->buildReportSql($this->SqlSelectSeries, $sqlChartBase, $chartFilter, $this->SqlGroupBySeries, "", $this->SqlOrderBySeries, $pageFilter, "");
                }
                $this->ChartSeriesSql = $sql->getSQL();
            }
        }

        // Run time sort, update SqlOrderBy
        if ($this->RunTimeSort) {
            $this->SqlOrderBy .= ($this->SortType == 2) ? " DESC" : "";
        }

        // Set up ChartSql
        if ($this->Table->SourceTableIsCustomView) {
            $sql = $this->buildReportSql($sqlChartSelect, $sqlChartBase, $this->SqlWhere, $this->SqlGroupBy, "", $this->SqlOrderBy, "", "");
        } else {
            $chartFilter = $this->SqlWhere;
            AddFilter($chartFilter, $this->Table->getSqlWhere());
            $sql = $this->buildReportSql($sqlChartSelect, $sqlChartBase, $chartFilter, $this->SqlGroupBy, "", $this->SqlOrderBy, $pageFilter, "");
        }
        $this->ChartSql = $sql->getSQL();
    }

    // Load chart data
    public function loadChartData()
    {
        // Data already loaded, return
        if ($this->dataLoaded) {
            return;
        }

        // Setup chart series data
        if ($this->ChartSeriesSql != "") {
            $this->loadSeries();
            if (Config("DEBUG")) {
                SetDebugMessage("(Chart Series SQL): " . $this->ChartSeriesSql);
            }
        }

        // Setup chart data
        if ($this->ChartSql != "") {
            $this->loadData();
            if (Config("DEBUG")) {
                SetDebugMessage("(Chart SQL): " . $this->ChartSql);
            }
        }

        // Sort data
        if ($this->SeriesFieldName != "" && $this->SeriesType != 1) {
            $this->sortMultiData();
        } else {
            $this->sortData();
        }
        $this->dataLoaded = true;
    }

    // Load Chart Series
    public function loadSeries()
    {
        $sql = $this->ChartSeriesSql;
        $cnn = Conn($this->Table->Dbid);
        $sdt = $this->SeriesDateType;
        $rows = $cnn->executeQuery($sql)->fetchAll(\PDO::FETCH_NUM);
        foreach ($rows as $row) {
            $this->Series[] = $this->seriesValue($row[0], $sdt); // Series value
        }
    }

    // Get Chart Series value
    public function seriesValue($val, $dt)
    {
        if ($dt == "syq") {
            $ar = explode("|", $val);
            if (count($ar) >= 2) {
                return $ar[0] . " " . QuarterName($ar[1]);
            } else {
                return $val;
            }
        } elseif ($dt == "sym") {
            $ar = explode("|", $val);
            if (count($ar) >= 2) {
                return $ar[0] . " " . MonthName($ar[1]);
            } else {
                return $val;
            }
        } elseif ($dt == "sq") {
            return QuarterName($val);
        } elseif ($dt == "sm") {
            return MonthName($val);
        } else {
            if (is_string($val)) {
                return trim($val);
            } else {
                return $val;
            }
        }
    }

    // Load Chart Data from SQL
    public function loadData()
    {
        $sql = $this->ChartSql;
        $cnn = Conn($this->Table->Dbid);
        $rows = $cnn->executeQuery($sql)->fetchAll(\PDO::FETCH_NUM);
        foreach ($rows as $row) {
            $this->Data[] = $row;
        }
    }

    // Get Chart X value
    public function getXValue($val, $dt)
    {
        if (is_numeric($dt)) {
            return FormatDateTime($val, $dt);
        } elseif ($dt == "y") {
            return $val;
        } elseif ($dt == "xyq") {
            $ar = explode("|", $val);
            if (count($ar) >= 2) {
                return $ar[0] . " " . QuarterName($ar[1]);
            } else {
                return $val;
            }
        } elseif ($dt == "xym") {
            $ar = explode("|", $val);
            if (count($ar) >= 2) {
                return $ar[0] . " " . MonthName($ar[1]);
            } else {
                return $val;
            }
        } elseif ($dt == "xq") {
            return QuarterName($val);
        } elseif ($dt == "xm") {
            return MonthName($val);
        } else {
            if (is_string($val)) {
                return trim($val);
            } else {
                return $val;
            }
        }
    }

    // Sort chart data
    public function sortData()
    {
        $ar = &$this->Data;
        $opt = $this->SortType;
        $seq = $this->SortSequence;
        if (($opt < 3 || $opt > 4) && $seq == "" || ($opt < 1 || $opt > 4) && $seq != "") {
            return;
        }
        if (is_array($ar)) {
            $cntar = count($ar);
            for ($i = 0; $i < $cntar; $i++) {
                for ($j = $i + 1; $j < $cntar; $j++) {
                    switch ($opt) {
                        case 1: // X values ascending
                            $swap = CompareValueCustom($ar[$i][0], $ar[$j][0], $seq);
                            break;
                        case 2: // X values descending
                            $swap = CompareValueCustom($ar[$j][0], $ar[$i][0], $seq);
                            break;
                        case 3: // Y values ascending
                            $swap = CompareValueCustom($ar[$i][2], $ar[$j][2], $seq);
                            break;
                        case 4: // Y values descending
                            $swap = CompareValueCustom($ar[$j][2], $ar[$i][2], $seq);
                    }
                    if ($swap) {
                        $tmpar = $ar[$i];
                        $ar[$i] = $ar[$j];
                        $ar[$j] = $tmpar;
                    }
                }
            }
        }
    }

    // Sort chart multi series data
    public function sortMultiData()
    {
        $ar = &$this->Data;
        $opt = $this->SortType;
        $seq = $this->SortSequence;
        if (!is_array($ar) || ($opt < 3 || $opt > 4) && $seq == "" || ($opt < 1 || $opt > 4) && $seq != "") {
            return;
        }

        // Obtain a list of columns
        foreach ($ar as $key => $row) {
            $xvalues[$key] = $row[0];
            $series[$key] = $row[1];
            $yvalues[$key] = $row[2];
            $ysums[$key] = $row[0]; // Store the x-value for the time being
            if (isset($xsums[$row[0]])) {
                $xsums[$row[0]] += $row[2];
            } else {
                $xsums[$row[0]] = $row[2];
            }
        }

        // Set up Y sum
        if ($opt == 3 || $opt == 4) {
            $cnt = count($ysums);
            for ($i = 0; $i < $cnt; $i++) {
                $ysums[$i] = $xsums[$ysums[$i]];
            }
        }

        // No specific sequence, use array_multisort
        if ($seq == "") {
            switch ($opt) {
                case 1: // X values ascending
                    array_multisort($xvalues, SORT_ASC, $ar);
                    break;
                case 2: // X values descending
                    array_multisort($xvalues, SORT_DESC, $ar);
                    break;
                case 3:
                case 4: // Y values
                    if ($opt == 3) { // Ascending
                        array_multisort($ysums, SORT_ASC, $ar);
                    } elseif ($opt == 4) { // Descending
                        array_multisort($ysums, SORT_DESC, $ar);
                    }
            }

        // Handle specific sequence
        } else {
            // Build key list
            if ($opt == 1 || $opt == 2) {
                $vals = array_unique($xvalues);
            } else {
                $vals = array_unique($ysums);
            }
            foreach ($vals as $key => $val) {
                $keys[] = [$key, $val];
            }

            // Sort key list based on specific sequence
            $cntkey = count($keys);
            for ($i = 0; $i < $cntkey; $i++) {
                for ($j = $i + 1; $j < $cntkey; $j++) {
                    switch ($opt) {
                        // Ascending
                        case 1:
                        case 3:
                            $swap = CompareValueCustom($keys[$i][1], $keys[$j][1], $seq);
                            break;
                        // Descending
                        case 2:
                        case 4:
                            $swap = CompareValueCustom($keys[$j][1], $keys[$i][1], $seq);
                            break;
                    }
                    if ($swap) {
                        $tmpkey = $keys[$i];
                        $keys[$i] = $keys[$j];
                        $keys[$j] = $tmpkey;
                    }
                }
            }
            for ($i = 0; $i < $cntkey; $i++) {
                $xsorted[] = $xvalues[$keys[$i][0]];
            }

            // Sort array based on x sequence
            $arwrk = $ar;
            $rowcnt = 0;
            $cntx = intval(count($xsorted));
            for ($i = 0; $i < $cntx; $i++) {
                foreach ($arwrk as $key => $row) {
                    if ($row[0] == $xsorted[$i]) {
                        $ar[$rowcnt] = $row;
                        $rowcnt++;
                    }
                }
            }
        }
    }

    // Get color
    public function getPaletteColor($i)
    {
        $colorpalette = $this->loadParameter("colorpalette");
        $colors = preg_split("/[|,\s]+/", $colorpalette);
        return is_array($colors) ? $colors[$i % count($colors)] : "";
    }

    // Get RGBA color
    public function getPaletteRgbaColor($i, $opacity = null)
    {
        $color = $this->getPaletteColor($i);

        // Return default if no color provided
        if (EmptyValue($color)) {
            return ""; // Use chart default
        }

        // Check opacity
        if ($opacity === null) {
            $alpha = $this->loadParameter("alpha");
            $opacity = GetOpacity($alpha);
        }
        return GetRgbaColor($color, $opacity);
    }

    // Format name for chart
    public function formatName($name)
    {
        global $Language;
        if ($name === null) {
            return $Language->phrase("NullLabel");
        } elseif ($name == "") {
            return $Language->phrase("EmptyLabel");
        }
        return $name;
    }

    // Is single series chart
    public function isSingleSeries()
    {
        return StartsString("1", strval($this->Type));
    }

    // Is zoom line chart
    public function isZoomLineChart()
    {
        return EndsString("92", strval($this->Type));
    }

    // Is column chart
    public function isColumnChart()
    {
        return EndsString("01", strval($this->Type));
    }

    // Is line chart
    public function isLineChart()
    {
        return EndsString("02", strval($this->Type));
    }

    // Is area chart
    public function isAreaChart()
    {
        return EndsString("03", strval($this->Type));
    }

    // Is bar chart
    public function isBarChart()
    {
        return EndsString("04", strval($this->Type));
    }

    // Is pie chart
    public function isPieChart()
    {
        return EndsString("05", strval($this->Type));
    }

    // Is doughnut chart
    public function isDoughnutChart()
    {
        return EndsString("06", strval($this->Type));
    }

    // Is stack chart
    public function isStackedChart()
    {
        return StartsString("3", strval($this->Type)) || in_array(strval($this->Type), ["4021", "4121", "4141"]);
    }

    // Is combination chart
    public function isCombinationChart()
    {
        return StartsString("4", strval($this->Type));
    }

    // Is dual axis chart
    public function isDualAxisChart()
    {
        return in_array(strval($this->Type), ["4031", "4131", "4141"]);
    }

    // Format number for chart
    public function formatNumber($v)
    {
        $cht_decimalprecision = $this->loadParameter("decimals");
        if ($cht_decimalprecision === null) {
            if ($this->DefaultDecimalPrecision >= 0) {
                $cht_decimalprecision = $this->DefaultDecimalPrecision; // Use default precision
            } else {
                $cht_decimalprecision = (($v - (int)$v) == 0) ? 0 : strlen(abs($v - (int)$v)) - 2; // Use original decimal precision
            }
        }
        return number_format($v, $cht_decimalprecision, ".", "");
    }

    // Get chart X SQL
    public function getXSql($fldsql, $fldtype, $val, $dt)
    {
        $dbid = $this->Table->Dbid;
        if (is_numeric($dt)) {
            return $fldsql . " = " . QuotedValue(UnFormatDateTime($val, $dt), $fldtype, $dbid);
        } elseif ($dt == "y") {
            if (is_numeric($val)) {
                return GroupSql($fldsql, "y", 0, $dbid) . " = " . QuotedValue($val, DATATYPE_NUMBER, $dbid);
            } else {
                return $fldsql . " = " . QuotedValue($val, $fldtype, $dbid);
            }
        } elseif ($dt == "xyq") {
            $ar = explode("|", $val);
            if (count($ar) >= 2 && is_numeric($ar[0]) && is_numeric($ar[1])) {
                return GroupSql($fldsql, "y", 0, $dbid) . " = " . QuotedValue($ar[0], DATATYPE_NUMBER, $dbid) . " AND " . GroupSql($fldsql, "xq", 0, $dbid) . " = " . QuotedValue($ar[1], DATATYPE_NUMBER, $dbid);
            } else {
                return $fldsql . " = " . QuotedValue($val, $fldtype, $dbid);
            }
        } elseif ($dt == "xym") {
            $ar = explode("|", $val);
            if (count($ar) >= 2 && is_numeric($ar[0]) && is_numeric($ar[1])) {
                return GroupSql($fldsql, "y", 0, $dbid) . " = " . QuotedValue($ar[0], DATATYPE_NUMBER, $dbid) . " AND " . GroupSql($fldsql, "xm", 0, $dbid) . " = " . QuotedValue($ar[1], DATATYPE_NUMBER, $dbid);
            } else {
                return $fldsql . " = " . QuotedValue($val, $fldtype, $dbid);
            }
        } elseif ($dt == "xq") {
            return GroupSql($fldsql, "xq", 0, $dbid) . " = " . QuotedValue($val, DATATYPE_NUMBER, $dbid);
        } elseif ($dt == "xm") {
            return GroupSql($fldsql, "xm", 0, $dbid) . " = " . QuotedValue($val, DATATYPE_NUMBER, $dbid);
        } else {
            return $fldsql . " = " . QuotedValue($val, $fldtype, $dbid);
        }
    }

    // Get chart series SQL
    public function getSeriesSql($fldsql, $fldtype, $val, $dt)
    {
        $dbid = $this->Table->Dbid;
        if ($dt == "syq") {
            $ar = explode("|", $val);
            if (count($ar) >= 2 && is_numeric($ar[0]) && is_numeric($ar[1])) {
                return GroupSql($fldsql, "y", 0, $dbid) . " = " . QuotedValue($ar[0], DATATYPE_NUMBER, $dbid) . " AND " . GroupSql($fldsql, "xq", 0, $dbid) . " = " . QuotedValue($ar[1], DATATYPE_NUMBER, $dbid);
            } else {
                return $fldsql . " = " . QuotedValue($val, $fldtype, $dbid);
            }
        } elseif ($dt == "sym") {
            $ar = explode("|", $val);
            if (count($ar) >= 2 && is_numeric($ar[0]) && is_numeric($ar[1])) {
                return GroupSql($fldsql, "y", 0, $dbid) . " = " . QuotedValue($ar[0], DATATYPE_NUMBER, $dbid) . " AND " . GroupSql($fldsql, "xm", 0, $dbid) . " = " . QuotedValue($ar[1], DATATYPE_NUMBER, $dbid);
            } else {
                return $fldsql . " = " . QuotedValue($val, $fldtype, $dbid);
            }
        } elseif ($dt == "sq") {
            return GroupSql($fldsql, "xq", 0, $dbid) . " = " . QuotedValue($val, DATATYPE_NUMBER, $dbid);
        } elseif ($dt == "sm") {
            return GroupSql($fldsql, "xm", 0, $dbid) . " = " . QuotedValue($val, DATATYPE_NUMBER, $dbid);
        } else {
            return $fldsql . " = " . QuotedValue($val, $fldtype, $dbid);
        }
    }

    // Show chart temp image
    public function getTempImageTag()
    {
        global $ExportType;
        $chartid = "chart_" . $this->ID;
        $chartImage = TempChartImage($chartid, $this->IsCustomTemplate);
        $this->resizeTempImage($chartImage);
        $wrk = "";
        if ($chartImage != "") {
            $wrk .= "<img src=\"" . $chartImage . "\" alt=\"\">";
            if ($this->PageBreak) {
                $attr = " data-page-break=\"" . ($this->PageBreakType == "before" ? "before" : "after") . "\"";
            }
            if ($ExportType == "word" && Config("USE_PHPWORD") || $ExportType == "excel" && Config("USE_PHPEXCEL") || $ExportType == "pdf") {
                $wrk = "<table class=\"ew-chart\"" . $attr . "><tr><td>" . $wrk . "</td></tr></table>";
            } else {
                $wrk = "<div class=\"ew-chart\"" . $attr . ">" . $wrk . "</div>";
            }
        }
        if ($this->PageBreak) {
            if ($this->PageBreakType == "before") {
                $wrk = $this->PageBreakContent . $wrk;
            } else {
                $wrk .= $this->PageBreakContent;
            }
        }
        return $wrk;
    }

    // Resize temp image
    public function resizeTempImage($fn)
    {
        global $ExportType;
        $portrait = SameText($this->Table->ExportPageOrientation, "portrait");
        $exportPdf = ($ExportType == "pdf");
        $exportWord = ($ExportType == "word" && Config("USE_PHPWORD"));
        $exportExcel = ($ExportType == "excel" && Config("USE_PHPEXCEL"));
        if ($exportPdf) {
            $maxWidth = $portrait ? Config("PDF_MAX_IMAGE_WIDTH") : Config("PDF_MAX_IMAGE_HEIGHT");
            $maxHeight = $portrait ? Config("PDF_MAX_IMAGE_HEIGHT") : Config("PDF_MAX_IMAGE_WIDTH");
        } elseif ($exportWord) {
            global $WORD_MAX_IMAGE_WIDTH, $WORD_MAX_IMAGE_HEIGHT;
            $maxWidth = $portrait ? $WORD_MAX_IMAGE_WIDTH : $WORD_MAX_IMAGE_HEIGHT;
            $maxHeight = $portrait ? $WORD_MAX_IMAGE_HEIGHT : $WORD_MAX_IMAGE_WIDTH;
        } elseif ($exportExcel) {
            global $EXCEL_MAX_IMAGE_WIDTH, $EXCEL_MAX_IMAGE_HEIGHT;
            $maxWidth = $portrait ? $EXCEL_MAX_IMAGE_WIDTH : $EXCEL_MAX_IMAGE_HEIGHT;
            $maxHeight = $portrait ? $EXCEL_MAX_IMAGE_HEIGHT : $EXCEL_MAX_IMAGE_WIDTH;
        }
        if ($exportPdf || $exportWord || $exportExcel) {
            $w = ($this->Width > 0) ? min($this->Width, $maxWidth) : $maxWidth;
            $h = ($this->Height > 0) ? min($this->Height, $maxHeight) : $maxHeight;
            return ResizeFile($fn, $fn, $w, $h);
        }
        return true;
    }

    // Get renderAs
    public function getRenderAs($i)
    {
        $ar = explode(",", $this->SeriesRenderAs);
        return ($i < count($ar)) ? $ar[$i] : "";
    }

    // Has data
    public function hasData()
    {
        return is_array($this->Data) && count($this->Data) > 0;
    }

    // Render chart
    public function render($class = "", $width = -1, $height = -1)
    {
        global $ExportType, $CustomExportType, $DashboardReport, $Language, $Page;

        // Get renderer class
        $rendererClass = ChartTypes::getRendererClass($this->Type);

        // Check chart size
        if ($width <= 0) {
            $width = $this->Width;
        }
        if ($height <= 0) {
            $height = $this->Height;
        }
        if (!is_numeric($width) || $width <= 0) {
            $width = $rendererClass::$DefaultWidth;
        }
        if (!is_numeric($height) || $height <= 0) {
            $height = $rendererClass::$DefaultHeight;
        }

        // Set up chart
        $this->setupChart();

        // Output HTML
        echo '<div class="' . $class . '">'; // Start chart

        // Render chart content
        if ($ExportType == "" || $ExportType == "print" && $CustomExportType == "" || $ExportType == "email" && Post("contenttype") == "url") {
            // Load chart data
            $this->loadChartData();
            $this->loadParameters();
            $this->loadViewData();

            // Get renderer
            $renderer = new $rendererClass($this);

            // Output chart html first
            $isDashBoard = $DashboardReport;
            $chartDivName = $this->Table->TableVar . '_' . $this->ChartVar;
            $chartAnchor = 'cht_' . $chartDivName;
            $isDrillDown = isset($Page) ? $Page->DrillDown : false;
            $html = '<a id="' . $chartAnchor . '"></a>' .
                '<div id="div_ctl_' . $chartDivName . '" class="ew-chart">';
            if ($this->RunTimeSort && !$isDashBoard && !$isDrillDown && $ExportType == "" && $this->hasData()) {
                $html .= '<div class="ew-chart-sort mb-1">' .
                    '<form class="form-inline" action="' . CurrentPageUrl() . '#cht_' . $chartDivName . '">' .
                    $Language->phrase("ChartOrder") . '&nbsp;' .
                    '<select id="chartordertype" name="chartordertype" class="custom-select" onchange="this.form.submit();">' .
                    '<option value="1"' . ($this->SortType == '1' ? ' selected' : '') . '>' . $Language->phrase("ChartOrderXAsc") . '</option>' .
                    '<option value="2"' . ($this->SortType == '2' ? ' selected' : '') . '>' . $Language->phrase("ChartOrderXDesc") . '</option>' .
                    '<option value="3"' . ($this->SortType == "3" ? ' selected' : '') . '>' . $Language->phrase("ChartOrderYAsc") . '</option>' .
                    '<option value="4"' . ($this->SortType == "4" ? ' selected' : '') . '>' . $Language->phrase("ChartOrderYDesc") . '</option>' .
                    '</select>' .
                    '<input type="hidden" id="chartorder" name="chartorder" value="' . $this->ChartVar . '">' .
                    '</form>' .
                    '</div>';
            }
            $html .= $renderer->getContainer($width, $height);
            $html .= '</div>';
            echo $html;

            // Output JavaScript
            echo $renderer->getScript($width, $height);
        } elseif ($ExportType == "pdf" || $CustomExportType != "" || $ExportType == "email" || $ExportType == "excel" && Config("USE_PHPEXCEL") || $ExportType == "word" && Config("USE_PHPWORD")) { // Show temp image
            echo $this->getTempImageTag();
        }
        echo '</div>'; // End chart
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

    // Chart Rendered event
    public function chartRendered($chart)
    {
        // Example:
        // $chartData = &$chart->Data;
        // $chartOptions = &$chart->Options;
        // var_dump($this->ID, $chartData, $chartOptions); // View chart ID, data and options
        // if ($this->ID == "<Report>_<Chart>") { // Check chart ID
        // Your code to customize $chartData and/or $chartOptions;
        // }
    }
}
