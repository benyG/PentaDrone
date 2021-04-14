<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Upload class
 */
class HttpUpload
{
    public $Index = -1; // Index for multiple form elements
    public $Parent; // Parent field object
    public $UploadPath; // Upload path
    public $Message; // Error message
    public $DbValue; // Value from database
    public $Value = null; // Upload value
    public $FileName; // Upload file name
    public $FileSize; // Upload file size
    public $ContentType; // File content type
    public $ImageWidth; // Image width
    public $ImageHeight; // Image height
    public $Error; // Upload error
    public $UploadMultiple = false; // Multiple upload
    public $KeepFile = true; // Keep old file
    public $Plugins = []; // Plugins for Resize()

    // Constructor
    public function __construct($fld = null)
    {
        $this->Parent = $fld;
    }

    // Check file type of the uploaded file
    public function uploadAllowedFileExt($filename)
    {
        return CheckFileType($filename);
    }

    // Get upload file
    public function uploadFile()
    {
        $this->Value = null; // Reset first

        // Get file from token or FormData for API request
        // - NOTE: for add option, use normal path as file is already uploaded in session
        $fldvar = ($this->Index < 0) ? $this->Parent->FieldVar : substr($this->Parent->FieldVar, 0, 1) . $this->Index . substr($this->Parent->FieldVar, 1);
        if (IsApi() && Post("addopt") != "1") {
            RenderUploadField($this->Parent, $this->Index); // Set up old files
            $oldFileName = strval($this->FileName);
            if ($this->getUploadedFiles($this->Parent, false)) { // Try to get from FormData / Token
                $this->KeepFile = false;
            }
            $wrkvar = "fn_" . $fldvar;
            if (($fileNames = Post($wrkvar)) !== null) { // Get post back file names
                if ($this->Parent->DataType != DATATYPE_BLOB || empty($fileNames)) { // Non blob or delete file action
                    $this->FileName = $fileNames;
                }
            }
            if (!SameString(strval($this->FileName), $oldFileName)) { // File names changed
                $this->KeepFile = false;
            }
        } else {
            $wrkvar = "fn_" . $fldvar;
            $this->FileName = Post($wrkvar, ""); // Get file name
            $wrkvar = "fa_" . $fldvar;
            $this->KeepFile = (Post($wrkvar, "") == "1"); // Check if keep old file
        }
        if (!$this->KeepFile && $this->FileName != "" && !$this->UploadMultiple) {
            $f = UploadTempPath($this->Parent, $this->Index) . $this->FileName;
            if (file_exists($f)) {
                $this->Value = file_get_contents($f);
                $this->FileSize = filesize($f);
                $this->ContentType = ContentType($this->Value, $f);
                $sizes = @getimagesize($f);
                $this->ImageWidth = @$sizes[0];
                $this->ImageHeight = @$sizes[1];
            }
        }
        return true; // Normal return
    }

    // Get uploaded files
    public function getUploadedFiles($fld = null, $output = true)
    {
        global $Request, $Language, $Security;
        if (!is_object($Request)) {
            if ($output) {
                WriteJson(["success" => false, "error" => "No request object"]);
            }
            return false;
        }

        // Language object
        $Language = Container("language");
        $res = true;
        $req = $Request->getUploadedFiles();
        $files = [];

        // Validate request
        if (!is_array($req)) {
            if ($output) {
                WriteJson(["success" => false, "error" => "No uploaded files"]);
            }
            return false;
        }

        // Create temp folder
        $filetoken = strval(Random());
        if ($fld === null) { // API file upload request
            $path = UploadTempPath($filetoken, $this->Index);
        } else {
            $path = UploadTempPath($fld, $this->Index);
        }
        if (!CreateFolder($path)) {
            if ($output) {
                WriteJson(["success" => false, "error" => "Create folder '" . $path . "' failed."]);
            }
            return false;
        }

        // Move files to temp folder
        $fileName = "";
        $fileTypes = '/\\.(' . (Config("UPLOAD_ALLOWED_FILE_EXT") != "" ? str_replace(",", "|", Config("UPLOAD_ALLOWED_FILE_EXT")) : "[\s\S]+") . ')$/i';

        // Process multi part upload
        $name = $fld === null ? "" : $fld->Name;
        foreach ($req as $id => $uploadedFiles) {
            if ($id == $name || $name == "") {
                $ar = [];
                if (is_object($uploadedFiles)) { // Single upload
                    $fileName = $uploadedFiles->getClientFilename();
                    $fileSize = $uploadedFiles->getSize();
                    $ar["name"] = $fileName;
                    if (!preg_match($fileTypes, $fileName)) { // Check file extensions
                        $ar["success"] = false;
                        $ar["error"] = $Language->phrase("UploadErrMsgAcceptFileTypes");
                        $res = false;
                    } elseif (Config("MAX_FILE_SIZE") > 0 && $fileSize > Config("MAX_FILE_SIZE")) { // Check file size
                        $ar["success"] = false;
                        $ar["error"] = $Language->phrase("UploadErrMsgMaxFileSize");
                        $res = false;
                    } elseif ($this->moveUploadedFile($uploadedFiles, $path)) {
                        $ar["success"] = true;
                    } else {
                        $ar["success"] = false;
                        $ar["error"] = $uploadedFile->getError();
                        $res = false;
                    }
                } elseif (is_array($uploadedFiles)) { // Multiple upload
                    foreach ($uploadedFiles as $uploadedFile) {
                        if ($fileName != "") {
                            $fileName .= Config("MULTIPLE_UPLOAD_SEPARATOR");
                        }
                        $clientFilename = $uploadedFile->getClientFilename();
                        $fileSize = $uploadedFile->getSize();
                        $fileName .= $clientFilename;
                        $arwrk = ["name" => $clientFilename];
                        if (!preg_match($fileTypes, $clientFilename)) { // Check file extensions
                            $arwrk["success"] = false;
                            $arwrk["error"] = $Language->phrase("UploadErrMsgAcceptFileTypes");
                            $res = false;
                        } elseif (Config("MAX_FILE_SIZE") > 0 && $fileSize > Config("MAX_FILE_SIZE")) { // Check file size
                            $arwrk["success"] = false;
                            $arwrk["error"] = $Language->phrase("UploadErrMsgMaxFileSize");
                            $res = false;
                        } elseif ($this->moveUploadedFile($uploadedFile, $path)) {
                            $arwrk["success"] = true;
                        } else {
                            $arwrk["success"] = false;
                            $arwrk["error"] = $uploadedFile->getError();
                            $res = false;
                        }
                        $ar[] = $arwrk;
                    }
                }
                $files[$id] = $ar;
            }
        }

        // Process file token (uploaded in previous API file upload request)
        if ($name != "" && Post($name) !== null) {
            $token = Post($name);
            $tokenPath = UploadTempPath($token, $this->Index);
            try {
                if (@is_dir($tokenPath) && ($dh = opendir($tokenPath))) {
                    // Get all files in the folder
                    while (($file = readdir($dh)) !== false) {
                        if ($file == "." || $file == ".." || !is_file($tokenPath . $file)) {
                            continue;
                        }
                        if (file_exists($path . $file)) { // Delete old file first
                            @unlink($path . $file);
                        }
                        rename($tokenPath . $file, $path . $file); // Move to temp folder
                        if ($fileName != "") {
                            $fileName .= Config("MULTIPLE_UPLOAD_SEPARATOR");
                        }
                        $fileName .= $file;
                    }
                    CleanUploadTempPath($tokenPath, $this->Index); // Clean up
                }
            } catch (\Throwable $e) {
                if (Config("DEBUG")) {
                    throw $e;
                }
            }
        }
        $res = $fileName != "";
        $result = ["success" => $res, "files" => $files];
        if ($res) { // Add token if any file uploaded successfully
            $this->FileName = $fileName;
            $result[Config("API_FILE_TOKEN_NAME")] = $filetoken;
        } else { // All failed => clean path
            if ($fld === null) { // API file upload request
                CleanPath($path, true);
            }
        }
        if ($output) {
            WriteJson($result);
        }
        return $res;
    }

    /**
     * Get uploaded file names (with or without full path)
     *
     * @param string $filetoken File token to locate the uploaded temp path
     * @param bool $path Return file name with or without full path
     * @return array
     */
    public function getUploadedFileNames($filetoken, $fullPath = false)
    {
        if (EmptyValue($filetoken)) { // Remove
            return [];
        } else { // Load file name from token
            $path = UploadTempPath($filetoken, $this->Index);
            try {
                if (@is_dir($path) && ($dh = opendir($path))) {
                    $fileNames = [];
                    while (($file = readdir($dh)) !== false) { // Get all files in the folder
                        if ($file == "." || $file == ".." || !is_file($path . $file)) {
                            continue;
                        }
                        $fileNames[] = $fullPath ? $path . $file : $file;
                    }
                    return $fileNames;
                }
            } catch (\Throwable $e) {
                if (Config("DEBUG")) {
                    throw $e;
                }
            }
            return [];
        }
    }

    /**
     * Get uploaded file names (with or without full path)
     *
     * @param string $filetoken File token to locate the uploaded temp path
     * @param bool $path Return file name with or without full path
     * @return string
     */
    public function getUploadedFileName($filetoken, $fullPath = false)
    {
        return implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->getUploadedFileNames($filetoken, $fullPath));
    }

    /**
     * Resize image
     *
     * @param int $width Target width of image
     * @param int $height Target height of image
     * @param int $quality optional Deprecated, kept for backward compatibility only.
     * @return HttpUpload
     */
    public function resize($width, $height, $quality = 100)
    {
        if (!EmptyValue($this->Value)) {
            $wrkwidth = $width;
            $wrkheight = $height;
            if (ResizeBinary($this->Value, $wrkwidth, $wrkheight, $quality, $this->Plugins)) {
                if ($wrkwidth > 0 && $wrkheight > 0) {
                    $this->ImageWidth = $wrkwidth;
                    $this->ImageHeight = $wrkheight;
                }
                $this->FileSize = strlen($this->Value);
            }
        }
        return $this;
    }

    /**
     * Get file count
     */
    public function count()
    {
        if (!$this->UploadMultiple && !EmptyValue($this->Value)) {
            return 1;
        } elseif ($this->UploadMultiple && $this->FileName != "") {
            $ar = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->FileName);
            return count($ar);
        }
        return 0;
    }

    /**
     * Get temp file
     *
     * @param int $idx
     * @return object|object[] Instance(s) of thumbnail class (Config("THUMBNAIL_CLASS"))
     */
    public function getTempThumb($idx = -1)
    {
        $file = $this->getTempFile($idx);
        $cls = Config("THUMBNAIL_CLASS");
        if (is_string($file)) {
            return file_exists($file) ? new $cls($file, Config("RESIZE_OPTIONS"), $this->Plugins) : null;
        } elseif (is_array($file)) {
            $thumbs = [];
            foreach ($file as $fn) {
                if (file_exists($fn)) {
                    $thumbs[] = new $cls($fn, Config("RESIZE_OPTIONS"), $this->Plugins);
                }
            }
            return $thumbs;
        }
        return null;
    }

    /**
     * Save uploaded data to file
     *
     * @param string $newFileName New file name
     * @param bool $overWrite Overwrite existing file or not
     * @param int $idx Index of file
     * @return booleanean
     */
    public function saveToFile($newFileName, $overWrite, $idx = -1)
    {
        $path = ServerMapPath($this->UploadPath ?: $this->Parent->UploadPath);
        if (!EmptyValue($this->Value)) {
            if (trim(strval($newFileName)) == "") {
                $newFileName = $this->FileName;
            }
            if (!$overWrite) {
                $newFileName = UniqueFilename($path, $newFileName);
            }
            return SaveFile($path, $newFileName, $this->Value);
        } elseif ($idx >= 0) { // Use file from upload temp folder
            $file = $this->getTempFile($idx);
            if (file_exists($file)) {
                if (!$overWrite) {
                    $newFileName = UniqueFilename($path, $newFileName);
                }
                return CopyFile($path, $newFileName, $file);
            }
        }
        return false;
    }

    /**
     * Resize and save uploaded data to file
     *
     * @param int $width Target width of image
     * @param int $height Target height of image
     * @param int $quality Deprecated, kept for backward compatibility only.
     * @param string $newFileName New file name
     * @param bool $overWrite Overwrite existing file or not
     * @param int $idx optional Index of the file
     * @return HttpUpload
     */
    public function resizeAndSaveToFile($width, $height, $quality, $newFileName, $overWrite, $idx = -1)
    {
        $numargs = func_num_args();
        $args = func_get_args();
        $oldPath = $this->UploadPath;
        if ($numargs >= 6 && is_string($args[4])) { // resizeAndSaveToFile($width, $height, $quality, $path, $newFileName, $overWrite, $idx = -1)
            $this->UploadPath = $args[3]; // Relative to app root
            $newFileName = $args[4];
            $overWrite = $args[5];
            $idx = ($numargs > 6) ? $args[6] : -1;
        }
        $result = false;
        if (!EmptyValue($this->Value)) {
            $oldValue = $this->Value;
            $result = $this->resize($width, $height)->saveToFile($newFileName, $overWrite);
            $this->Value = $oldValue;
        } elseif ($idx >= 0) { // Use file from upload temp folder
            $file = $this->getTempFile($idx);
            if (file_exists($file)) {
                $this->Value = file_get_contents($file);
                $result = $this->resize($width, $height)->saveToFile($newFileName, $overWrite);
                $this->Value = null;
            }
        }
        $this->UploadPath = $oldPath;
        return $result;
    }

    // Move upload file
    protected function moveUploadedFile($uploadedFile, $path)
    {
        $uploadFileName = $uploadedFile->getClientFilename();
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $uploadedFile->moveTo($path . $uploadFileName);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get temp file path
     *
     * @param int $idx optional Index of file
     * @return string|string[]
     */
    public function getTempFile($idx = -1)
    {
        if ($this->FileName != "") {
            $path = UploadTempPath($this->Parent, $this->Index);
            if ($this->UploadMultiple) {
                $ar = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->FileName);
                if ($idx > -1 && $idx < count($ar)) {
                    return $path . $ar[$idx];
                } else {
                    $files = [];
                    foreach ($ar as $fn) {
                        $files[] = $path . $fn;
                    }
                    return $files;
                }
            } else {
                return $path . $this->FileName;
            }
        }
        return null;
    }
}
