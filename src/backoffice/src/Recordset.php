<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Recordset class
 */
class Recordset
{
    public $Statement;
    public $fields; // Note: Use lowercase for backward compatibility
    public $EOF = true;
    private $RowCount = -1;
    private $Sql;
    private $Connection;

    /**
     * Constructor
     *
     * @param Statement $statement Statement
     * @param QueryBuilder|string $sql QueryBuilder or SQL
     * @param Connection $c Connection (required if $sql is string)
     * @return void
     */
    public function __construct($statement, $sql = null, $c = null)
    {
        if ($statement) {
            $this->Statement =& $statement;
        }
        $this->Sql = $sql;
        $this->Connection = $c;
        $this->RowCount = $this->Statement->rowCount();
        $this->fields = $this->fetch();
    }

    // Record count
    public function recordCount()
    {
        if ($this->RowCount <= 0 && $this->Sql) {
            $this->RowCount = ExecuteRecordCount($this->Sql, $this->Connection);
        }
        return $this->RowCount;
    }

    // Move next
    public function moveNext()
    {
        $this->fields = $this->fetch();
    }

    // Move
    public function move($cnt)
    {
        for ($i = 0; $i < $cnt; $i++) {
            $this->fields = $this->fetch();
        }
    }

    // Get rows
    public function getRows()
    {
        return $this->Statement->fetchAll();
    }

    // Field count
    public function fieldCount()
    {
        return $this->Statement->columnCount();
    }

    // Set fetch mode
    public function setFetchMode($fetchMode, $arg2 = null, $arg3 = null)
    {
        $this->Statement->setFetchMode($fetchMode, $arg2, $arg3);
    }

    // Fetch
    public function fetch()
    {
        if ($this->Statement) {
            $res = $this->Statement->fetch();
            $this->EOF = $res === false;
            return $res;
        }
        return false;
    }

    // Close
    public function close()
    {
        $this->Statement->closeCursor();
    }
}
