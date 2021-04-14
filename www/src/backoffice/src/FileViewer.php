<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * File Viewer class
 */
class FileViewer
{
    /**
     * Output file
     *
     * @return bool Whether file is outputted successfully
     */
    public function getFile()
    {
        global $Security;

        // Get parameters
        $tbl = null;
        $tableName = "";
        if (IsPost()) {
            $token = !empty($GLOBALS["TokenName"]) ? Post($GLOBALS["TokenName"], "") : "";
            $sessionId = Post("session", "");
            $fn = Post("fn", "");
            $table = Post(Config("API_OBJECT_NAME"), "");
            $field = Post(Config("API_FIELD_NAME"), "");
            $recordkey = Post(Config("API_KEY_NAME"), "");
            $resize = Post("resize", "0") == "1";
            $width = Post("width", 0);
            $height = Post("height", 0);
            $download = Post("download", "1") == "1"; // Download by default
            $crop = Post("crop", "");
        } else { // api/file/object/field/key
            $token = !empty($GLOBALS["TokenName"]) ? Get($GLOBALS["TokenName"], "") : "";
            $sessionId = Get("session", "");
            $fn = Get("fn", "");
            if (!empty(Route(2)) && empty(Route(Config("API_KEY_NAME")))) {
                $fn = Route(2);
            }
            $table = Get(Config("API_OBJECT_NAME"), Route(1));
            $field = Get(Config("API_FIELD_NAME"), Route(2));
            $recordkey = Get(Config("API_KEY_NAME"), Route(Config("API_KEY_NAME")));
            $resize = Get("resize", "0") == "1";
            $width = Get("width", 0);
            $height = Get("height", 0);
            $download = Get("download", "1") == "1"; // Download by default
            $crop = Get("crop", "");
        }
        $sessionId = Decrypt($sessionId);
        $key = Config("RANDOM_KEY") . ($sessionId != "" ? $sessionId : "");
        if (!is_numeric($width)) {
            $width = 0;
        }
        if (!is_numeric($height)) {
            $height = 0;
        }
        if ($width == 0 && $height == 0 && $resize) {
            $width = Config("THUMBNAIL_DEFAULT_WIDTH");
            $height = Config("THUMBNAIL_DEFAULT_HEIGHT");
        }

        // Get table object
        $tbl = Container($table);
        $tableName = is_object($tbl) ? $tbl->TableName : "";

        // API request with table/fn
        if ($tableName != "") {
            $fn = Decrypt($fn, $key); // File path is always encrypted
        } else {
            $fn = "";
        }

        // Get image
        $res = false;
        $func = function ($phpthumb) use ($width, $height) {
            $phpthumb->adaptiveResize($width, $height);
        };
        $plugins = $crop ? [$func] : [];
        if ($fn != "") { // Physical file
            $fn = str_replace("\0", "", $fn);
            $info = pathinfo($fn);
            if (file_exists($fn) || @fopen($fn, "rb") !== false) {
                $ext = strtolower(@$info["extension"]);
                $isPdf = SameText($ext, "pdf");
                $ct = MimeContentType($fn);
                if ($ct) {
                    AddHeader("Content-type", $ct);
                }
                $data = "";
                if (in_array($ext, explode(",", Config("IMAGE_ALLOWED_FILE_EXT")))) { // Skip "Content-Disposition" header if images
                    if ($width > 0 || $height > 0) {
                        $data = ResizeFileToBinary($fn, $width, $height, $plugins);
                    } else {
                        $data = file_get_contents($fn);
                    }
                } elseif (in_array($ext, explode(",", Config("DOWNLOAD_ALLOWED_FILE_EXT")))) {
                    if ($download && !((Config("EMBED_PDF") || !Config("DOWNLOAD_PDF_FILE")) && $isPdf)) { // Skip header if embed/inline PDF
                        AddHeader("Content-Disposition", "attachment; filename=\"" . $info["basename"] . "\"");
                    }
                    $data = file_get_contents($fn);
                }
                Write($data);
                $res = true;
            }
        } elseif (is_object($tbl) && $field != "" && $recordkey != "") { // From table
            $res = $tbl->getFileData($field, $recordkey, $resize, $width, $height, $plugins);
        }
        return $res;
    }
}
