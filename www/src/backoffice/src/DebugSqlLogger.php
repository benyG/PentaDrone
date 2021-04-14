<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

use Doctrine\DBAL\Logging\SQLLogger;

/**
 * A SQL logger that logs to the log file
 */
class DebugSqlLogger implements SQLLogger
{
    /** @var float|null */
    public $start = null;

    /** @var array */
    public $query;

    /** @var string */
    public $sql;

    /**
     * {@inheritdoc}
     */
    public function startQuery($sql, ?array $params = null, ?array $types = null)
    {
        $this->start = microtime(true);
        $this->sql = $sql;
        $this->query = ["params" => $params, "types" => $types, "executionMS" => 0];
    }

    /**
     * {@inheritdoc}
     */
    public function stopQuery()
    {
        $this->query["executionMS"] = microtime(true) - $this->start;
        Log($this->sql, $this->query);
    }
}
