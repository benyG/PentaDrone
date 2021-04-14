<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Report field class
 */
class ReportField extends DbField
{
    public $SumValue; // Sum
    public $AvgValue; // Average
    public $MinValue; // Minimum
    public $MaxValue; // Maximum
    public $CntValue; // Count
    public $SumViewValue; // Sum
    public $AvgViewValue; // Average
    public $MinViewValue; // Minimum
    public $MaxViewValue; // Maximum
    public $CntViewValue; // Count
    public $DrillDownTable = ""; // Drill down table name
    public $DrillDownUrl = ""; // Drill down URL
    public $CurrentFilter = ""; // Current filter in use
    public $GroupingFieldId = 0; // Grouping field id
    public $ShowGroupHeaderAsRow = false; // Show grouping level as row
    public $ShowCompactSummaryFooter = true; // Show compact summary footer
    public $GroupByType; // Group By Type
    public $GroupInterval; // Group Interval
    public $GroupSql; // Group SQL
    public $GroupValue; // Group Value
    public $GroupViewValue; // Group View Value
    public $DateFilter; // Date Filter ("year"|"quarter"|"month"|"day"|"")
    public $Delimiter = ""; // Field delimiter (e.g. comma) for delimiter separated value
    public $DistinctValues = [];
    public $Records = [];
    public $LevelBreak = false;

    // Database value (override PHPMaker)
    public function setDbValue($v)
    {
        if ($this->Type == 131 || $this->Type == 139) { // Convert adNumeric/adVarNumeric field
            $v = floatval($v);
        }
        parent::setDbValue($v); // Call parent method
    }

    // Group value
    public function groupValue()
    {
        return $this->GroupValue;
    }

    // Set group value
    public function setGroupValue($v)
    {
        $this->setDbValue($v);
        $this->GroupValue = $this->DbValue;
    }

    // Get select options HTML (override)
    public function selectOptionListHtml($name = "")
    {
        $html = parent::selectOptionListHtml($name);
        return str_replace(">" . INIT_VALUE . "</option>", "></option>", $html); // Do not show the INIT_VALUE as value
    }

    // Get distinct values
    public function getDistinctValues($records)
    {
        $name = $this->getGroupName();
        $ar = from($records)
            ->distinct(function ($record) use ($name) {
                return $record[$name];
            })
            ->orderBy(function ($record) use ($name) {
                return $record[$name];
            })
            ->toArrayDeep();
        $this->DistinctValues = array_column($ar, $name);
    }

    // Get distinct records
    public function getDistinctRecords($records, $val)
    {
        $name = $this->getGroupName();
        $this->Records = from($records)
            ->where(function ($record) use ($name, $val) {
                return $record[$name] == $val;
            })
            ->toArrayDeep();
    }

    // Get Sum
    public function getSum($records)
    {
        $name = $this->getGroupName();
        $sum = 0;
        if (count($records) > 0) {
            $sum = from($records)->sum(function ($record) use ($name) {
                return $record[$name];
            });
        }
        $this->SumValue = $sum;
    }

    // Get Avg
    public function getAvg($records)
    {
        $name = $this->getGroupName();
        $avg = 0;
        if (count($records) > 0) {
            $avg = from($records)->average(function ($record) use ($name) {
                return $record[$name];
            });
        }
        $this->AvgValue = $avg;
    }

    // Get Min
    public function getMin($records)
    {
        $name = $this->getGroupName();
        $min = null;
        if (count($records) > 0) {
            $min = from($records)->min(function ($record) use ($name) {
                return $record[$name];
            });
        }
        $this->MinValue = $min;
    }

    // Get Max
    public function getMax($records)
    {
        $name = $this->getGroupName();
        $max = null;
        if (count($records) > 0) {
            $notNull = from($records)->where(function ($record) use ($name) {
                return !is_null($record[$name]);
            })->toArrayDeep();
            if (count($notNull) > 0) {
                $max = from($notNull)->max(function ($record) use ($name) {
                    return $record[$name];
                });
            }
        }
        $this->MaxValue = $max;
    }

    // Get Cnt
    public function getCnt($records)
    {
        $name = $this->getGroupName();
        $cnt = 0;
        if (count($records) > 0) {
            $cnt = from($records)->count(function ($record) use ($name) {
                return $record[$name];
            });
        }
        $this->CntValue = $cnt;
        $this->Count = $cnt;
    }

    // Get group name
    public function getGroupName()
    {
        return $this->GroupSql != "" ? "EW_GROUP_VALUE_" . $this->GroupingFieldId : $this->Name;
    }

    /**
     * Format advanced filters
     *
     * @param array $ar
     */
    function FormatAdvancedFilters($ar)
    {
        if (is_array($ar) && is_array($this->AdvancedFilters)) {
            foreach ($ar as &$arwrk) {
                if (StartsString("@@", @$arwrk[0]) && SameString(@$arwrk[0], @$arwrk[1])) {
                    $key = substr($arwrk[0], 2);
                    if (array_key_exists($key, $this->AdvancedFilters)) {
                        $arwrk[1] = $this->AdvancedFilters[$key]->Name;
                    }
                }
            }
        }
        return $ar;
    }
}
