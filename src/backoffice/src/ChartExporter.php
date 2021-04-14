<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Chart exporter class
 */
class ChartExporter
{
    // Export
    public function export()
    {
        global $Language;
        $json = Post("charts", "[]");
        $charts = json_decode($json);
        $files = [];
        foreach ($charts as $chart) {
            $img = false;
            // Charts base64
            if ($chart->stream_type == "base64") {
                try {
                    $img = base64_decode(preg_replace('/^data:image\/\w+;base64,/', "", $chart->stream));
                } catch (\Throwable $e) {
                    return $this->serverError($e->getMessage());
                }
            }
            if ($img === false) {
                return $this->serverError(str_replace(["%t", "%e"], [$chart->stream_type, $chart->chart_engine], $Language->phrase("ChartExportErrMsg1")));
            }

            // Save the file
            $params = $chart->parameters;
            $filename = "";
            if (preg_match('/exportfilename=(\w+\.png)\|/', $params, $matches)) { // Must be .png for security
                $filename = $matches[1];
            }
            if ($filename == "") {
                return $this->serverError($Language->phrase("ChartExportErrMsg2"));
            }
            $path = ServerMapPath(Config("UPLOAD_DEST_PATH"));
            $realpath = realpath($path);
            if (!file_exists($realpath)) {
                return $this->serverError($Language->phrase("ChartExportErrMsg3"));
            }
            if (!is_writable($realpath)) {
                return $this->serverError($Language->phrase("ChartExportErrMsg4"));
            }
            $filepath = realpath($path) . PATH_DELIMITER . $filename;
            file_put_contents($filepath, $img);
            $files[] = $filename;
        }

        // Write success response
        WriteJson(["success" => true, "files" => $files]);
        return true;
    }

    // Send server error
    protected function serverError($msg)
    {
        WriteJson(["success" => false, "error" => $msg]);
        return false;
    }
}
