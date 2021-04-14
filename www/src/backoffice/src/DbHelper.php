<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Class DbHelper
 */
class DbHelper
{
    // Connection
    public $Connection;

    // Constructor
    public function __construct($dbid = 0)
    {
        $this->Connection = GetConnection($dbid); // Open connection
    }

    // Connection ID
    public function connectionId()
    {
        return GetConnectionId($dbid);
    }

    // Executes the query, and returns the row(s) as JSON
    public function executeJson($sql, $options = null)
    {
        return ExecuteJson($sql, $options, $this->Connection);
    }

    // Execute UPDATE, INSERT, or DELETE statements
    public function execute($sql, $fn = null)
    {
        return Execute($sql, $fn, $this->Connection);
    }

    // Executes the query, and returns the first column of the first row
    public function executeScalar($sql)
    {
        return ExecuteScalar($sql, $this->Connection);
    }

    // Executes the query, and returns the first row
    public function executeRow($sql, $mode = -1)
    {
        return ExecuteRow($sql, $this->Connection, $mode);
    }

    // Executes the query, and returns all rows
    public function executeRows($sql, $mode = -1)
    {
        return ExecuteRows($sql, $this->Connection, $mode);
    }

    // Executes the query, and returns as HTML
    public function executeHtml($sql, $options = null)
    {
        return ExecuteHtml($sql, $options, $this->Connection);
    }

    // Load recordset
    public function &loadRecordset($sql, $mode = -1)
    {
        return LoadRecordset($sql, $this->Connection, $mode);
    }
}
