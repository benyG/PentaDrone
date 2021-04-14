<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\LineFormatter;
use Monolog\Formatter\NormalizerFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Utils;

/**
 * Stores to CSV file
 */
class AuditTrailHandler extends RotatingFileHandler
{
    public static $Delimiter = ",";
    public static $Enclosure = '"';
    public static $EscapeChar = "\\";
    public static $UseHeader = true;
    public static $Headers = ["date/time", "script", "user", "action", "table", "field", "key value", "old value", "new value"];
    private $writeHeader = true;

    /**
     * @inheritdoc
     */
    protected function streamWrite($stream, array $record): void
    {
        if (self::$UseHeader && filesize($this->url) == 0 && $this->writeHeader) {
            fputcsv($stream, self::$Headers, self::$Delimiter, self::$Enclosure, self::$EscapeChar); // Write headers
            $this->writeHeader = false; // No need to write header again (file size may be 0 due to buffering)
        }
        if (is_array($record["context"])) {
            foreach ($record["context"] as $key => $info) {
                if (is_array($info)) {
                    $record["context"][$key] = Utils::jsonEncode($info);
                }
            }
        }
        fputcsv($stream, (array)$record["context"], self::$Delimiter, self::$Enclosure, self::$EscapeChar);
    }

    /**
     * Gets the default formatter.
     *
     * Overwrite this if the LineFormatter is not a good default for your handler.
     */
    protected function getDefaultFormatter(): FormatterInterface
    {
        return new NormalizerFormatter();
    }
}
