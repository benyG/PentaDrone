<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Field class
 */
class DbField
{
    public $TableName; // Table name
    public $TableVar; // Table variable name
    public $SourceTableVar = ""; // Source Table variable name (for Report only)
    public $Name; // Field name
    public $FieldVar; // Field variable name
    public $Param; // Field parameter name
    public $Expression; // Field expression (used in SQL)
    public $BasicSearchExpression; // Field expression (used in basic search SQL)
    public $LookupExpression = ""; // Lookup expression
    public $IsCustom = false; // Custom field
    public $IsVirtual; // Virtual field
    public $VirtualExpression; // Virtual field expression (used in ListSQL)
    public $ForceSelection; // Autosuggest force selection
    public $SelectMultiple; // Select multiple
    public $VirtualSearch; // Search as virtual field
    public $ErrorMessage = ""; // Error message
    public $DefaultErrorMessage; // Default error message
    public $IsInvalid = false; // Invalid
    public $VirtualValue; // Virtual field value
    public $TooltipValue; // Field tooltip value
    public $TooltipWidth = 0; // Field tooltip width
    public $Type; // Field type
    public $Size; // Field size
    public $DataType; // PHPMaker Field type
    public $BlobType; // For Oracle only
    public $ViewTag; // View Tag
    public $HtmlTag; // Html Tag
    public $IsDetailKey = false; // Field is detail key
    public $IsAutoIncrement = false; // Autoincrement field (FldAutoIncrement)
    public $IsPrimaryKey = false; // Primary key (FldIsPrimaryKey)
    public $IsForeignKey = false; // Foreign key (Master/Detail key)
    public $IsEncrypt = false; // Field is encrypted
    public $Raw; // Raw value (save without removing XSS)
    public $Nullable = true; // Nullable
    public $Required = false; // Required
    public $AdvancedSearch; // AdvancedSearch Object
    public $AdvancedFilters; // Advanced Filters
    public $Upload; // Upload Object
    public $DateTimeFormat; // Date time format
    public $CssStyle; // CSS style
    public $CssClass; // CSS class
    public $ImageAlt; // Image alt
    public $ImageWidth = 0; // Image width
    public $ImageHeight = 0; // Image height
    public $ImageResize = false; // Image resize
    public $IsBlobImage = false; // Is blob image
    public $ViewCustomAttributes; // View custom attributes
    public $EditCustomAttributes; // Edit custom attributes
    public $LinkCustomAttributes; // Link custom attributes
    public $Count; // Count
    public $Total; // Total
    public $TrueValue = '1';
    public $FalseValue = '0';
    public $Visible = true; // Visible
    public $Disabled; // Disabled
    public $ReadOnly = false; // Read only
    public $MemoMaxLength = 0; // Maximum length for memo field in list page
    public $TruncateMemoRemoveHtml; // Remove HTML from memo field
    public $CustomMsg = ""; // Custom message
    public $CellCssClass = ""; // Cell CSS class
    public $CellCssStyle = ""; // Cell CSS style
    public $CellCustomAttributes = ""; // Cell custom attributes
    public $HeaderCellCssClass = ""; // Header cell (<th>) CSS class
    public $FooterCellCssClass = ""; // Footer cell (<td> in <tfoot>) CSS class
    public $MultiUpdate; // Multi update
    public $OldValue = null; // Old Value
    public $ConfirmValue; // Confirm value
    public $CurrentValue; // Current value
    public $ViewValue; // View value (string|Object)
    public $EditValue; // Edit value
    public $EditValue2; // Edit value 2 (for search)
    public $HrefValue; // Href value
    public $ExportHrefValue; // Href value for export
    public $FormValue; // Form value
    public $QueryStringValue; // QueryString value
    public $DbValue; // Database value
    public $Sortable = true; // Sortable
    public $UploadPath; // Upload path
    public $OldUploadPath; // Old upload path (for deleting old image)
    public $HrefPath; // Href path (for download)
    public $UploadAllowedFileExt; // Allowed file extensions
    public $UploadMaxFileSize; // Upload max file size
    public $UploadMaxFileCount; // Upload max file count
    public $UploadMultiple = false; // Multiple Upload
    public $UseColorbox; // Use Colorbox
    public $CellAttrs; // Cell custom attributes
    public $EditAttrs; // Edit custom attributes
    public $ViewAttrs; // View custom attributes
    public $LinkAttrs; // Link custom attributes
    public $DisplayValueSeparator = ", ";
    public $AutoFillOriginalValue;
    public $RequiredErrorMessage;
    public $Lookup = null;
    public $OptionCount = 0;
    public $UseLookupCache; // Use lookup cache
    public $LookupCacheCount; // Lookup cache count
    public $PlaceHolder = "";
    public $Caption = "";
    public $UsePleaseSelect = true;
    public $PleaseSelectText = "";
    public $Exportable = true;
    public $ExportOriginalValue;
    public $ExportFieldImage;
    public $DefaultDecimalPrecision;

    // Constructor
    public function __construct($tblvar, $tblname, $fldvar, $fldname, $fldexp, $fldbsexp, $fldtype, $fldsize, $flddtfmt, $upload, $fldvirtualexp, $fldvirtual, $forceselect, $fldvirtualsrch, $fldviewtag = "", $fldhtmltag = "")
    {
        global $Language;
        $this->CellAttrs = new Attributes();
        $this->EditAttrs = new Attributes();
        $this->ViewAttrs = new Attributes();
        $this->LinkAttrs = new Attributes();
        $this->Raw = !Config("REMOVE_XSS");
        $this->UploadPath = Config("UPLOAD_DEST_PATH");
        $this->OldUploadPath = Config("UPLOAD_DEST_PATH");
        $this->HrefPath = Config("UPLOAD_HREF_PATH");
        $this->UploadAllowedFileExt = Config("UPLOAD_ALLOWED_FILE_EXT");
        $this->UploadMaxFileSize = Config("MAX_FILE_SIZE");
        $this->UploadMaxFileCount = Config("MAX_FILE_COUNT");
        $this->UseColorbox = Config("USE_COLORBOX");
        $this->AutoFillOriginalValue = Config("AUTO_FILL_ORIGINAL_VALUE");
        $this->UseLookupCache = Config("USE_LOOKUP_CACHE");
        $this->LookupCacheCount = Config("LOOKUP_CACHE_COUNT");
        $this->ExportOriginalValue = Config("EXPORT_ORIGINAL_VALUE");
        $this->ExportFieldImage = Config("EXPORT_FIELD_IMAGE");
        $this->DefaultDecimalPrecision = Config("DEFAULT_DECIMAL_PRECISION");
        $this->TableVar = $tblvar;
        $this->TableName = $tblname;
        $this->FieldVar = $fldvar;
        $this->Param = preg_replace('/^x_/', "", $this->FieldVar); // Remove "x_"
        $this->Name = $fldname;
        $this->Expression = $fldexp;
        $this->BasicSearchExpression = $fldbsexp;
        $this->Type = $fldtype;
        $this->Size = $fldsize;
        $this->DataType = FieldDataType($fldtype);
        $this->DateTimeFormat = $flddtfmt;
        $this->AdvancedSearch = new AdvancedSearch($this->TableVar, $this->Param);
        if ($upload) {
            $this->Upload = new HttpUpload($this);
        }
        $this->VirtualExpression = $fldvirtualexp;
        $this->IsVirtual = $fldvirtual;
        $this->ForceSelection = $forceselect;
        $this->VirtualSearch = $fldvirtualsrch;
        $this->ViewTag = $fldviewtag;
        $this->HtmlTag = $fldhtmltag;
        $this->RequiredErrorMessage = $Language->phrase("EnterRequiredField");
        $this->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
    }

    // Is boolean field
    public function isBoolean()
    {
        return $this->DataType == DATATYPE_BOOLEAN || $this->DataType == DATATYPE_BIT && $this->Size == 1;
    }

    // Is selected for multiple update
    public function multiUpdateSelected()
    {
        return $this->MultiUpdate == 1;
    }

    // Field encryption/decryption required
    public function isEncrypt()
    {
        $encrypt = $this->IsEncrypt && ($this->DataType == DATATYPE_STRING || $this->DataType == DATATYPE_MEMO) &&
            !$this->IsPrimaryKey && !$this->IsAutoIncrement && !$this->IsForeignKey;
        // Do not encrypt username/password/userid/parent userid/userlevel/profile/activate fields in user table
        if (
            $encrypt &&
            $this->TableName == Config("USER_TABLE_NAME") &&
            in_array($this->Name, [Config("LOGIN_USERNAME_FIELD_NAME"),
                Config("LOGIN_PASSWORD_FIELD_NAME"), Config("USER_ID_FIELD_NAME"),
                Config("PARENT_USER_ID_FIELD_NAME"), Config("USER_LEVEL_FIELD_NAME"),
                Config("USER_PROFILE_FIELD_NAME"), Config("REGISTER_ACTIVATE_FIELD_NAME")])
        ) {
            $encrypt = false;
        }
        return $encrypt;
    }

    // Get Custom Message (help text)
    public function getCustomMessage()
    {
        $msg = trim($this->CustomMsg);
        if (EmptyValue($msg)) {
            return "";
        }
        if (preg_match('/^<.+>$/', $msg)) { // Html content
            return $msg;
        } else {
            return '<small id="' . $this->FieldVar . '_help" class="form-text text-muted">' . $msg . '</small>';
        }
    }

    // Get Input type attribute (TEXT only)
    public function getInputTextType()
    {
        return $this->EditAttrs->offsetExists("type") ? $this->EditAttrs["type"] : "text";
    }

    // Get place holder
    public function getPlaceHolder()
    {
        return ($this->ReadOnly || $this->EditAttrs->offsetExists("readonly")) ? "" : $this->PlaceHolder;
    }

    // Set field caption
    public function setCaption($v)
    {
        $this->Caption = $v;
    }

    // Field caption
    public function caption()
    {
        global $Language;
        if ($this->Caption == "") {
            return $Language->fieldPhrase($this->TableVar, $this->Param, "FldCaption");
        }
        return $this->Caption;
    }

    // Field title
    public function title()
    {
        global $Language;
        return $Language->fieldPhrase($this->TableVar, $this->Param, "FldTitle");
    }

    // Field image alt
    public function alt()
    {
        global $Language;
        return $Language->FieldPhrase($this->TableVar, $this->Param, "FldAlt");
    }

    // Clear error message
    public function clearErrorMessage()
    {
        $this->IsInvalid = false;
        $this->ErrorMessage = "";
    }

    // Add error message
    public function addErrorMessage($message)
    {
        $this->IsInvalid = true;
        AddMessage($this->ErrorMessage, $message);
    }

    // Field error message
    public function getErrorMessage($required = true)
    {
        global $Language;
        $err = $this->ErrorMessage;
        if ($err == "") {
            $err = $Language->FieldPhrase($this->TableVar, $this->Param, "FldErrMsg");
            if ($err == "" && !EmptyString($this->DefaultErrorMessage)) {
                $err = $this->DefaultErrorMessage . " - " . $this->caption();
            }
            if ($this->Required && $required) {
                AddMessage($err, str_replace("%s", $this->caption(), $this->RequiredErrorMessage));
            }
        }
        return $err;
    }

    // Get is-invalid class
    public function isInvalidClass()
    {
        return $this->IsInvalid ? " is-invalid" : "";
    }

    // Field option value
    public function tagValue($i)
    {
        global $Language;
        return $Language->fieldPhrase($this->TableVar, $this->Param, "FldTagValue" . $i);
    }

    // Field option caption
    public function tagCaption($i)
    {
        global $Language;
        return $Language->fieldPhrase($this->TableVar, $this->Param, "FldTagCaption" . $i);
    }

    // Set field visibility
    public function setVisibility()
    {
        $this->Visible = Container($this->TableVar)->getFieldVisibility($this->Param);
    }

    // Check if multiple selection
    public function isMultiSelect()
    {
        return $this->HtmlTag == "SELECT" && $this->SelectMultiple || $this->HtmlTag == "CHECKBOX";
    }

    // Field lookup cache option
    public function lookupCacheOption($val)
    {
        $val = strval($val);
        if ($val == "" || $this->Lookup === null || !is_array($this->Lookup->Options) || count($this->Lookup->Options) == 0) {
            return null;
        }
        $res = null;
        if ($this->isMultiSelect()) { // Multiple options
            $res = new OptionValues();
            $arwrk = explode(",", $val);
            foreach ($arwrk as $wrk) {
                $wrk = trim($wrk);
                if (array_key_exists($wrk, $this->Lookup->Options)) { // Lookup data found in cache
                    $ar = $this->Lookup->Options[$wrk];
                    $res->add($this->displayValue($ar));
                } else {
                    $res->add($val); // Not found, use original value
                }
            }
        } else {
            if (array_key_exists($val, $this->Lookup->Options)) { // Lookup data found in cache
                $ar = $this->Lookup->Options[$val];
                $res = $this->displayValue($ar);
            } else {
                $res = $val; // Not found, use original value
            }
        }
        return $res;
    }

    // Field lookup options
    public function lookupOptions()
    {
        if ($this->Lookup !== null && is_array($this->Lookup->Options)) {
            return array_values($this->Lookup->Options);
        }
        return [];
    }

    // Field option caption by option value
    public function optionCaption($val)
    {
        for ($i = 0; $i < $this->OptionCount; $i++) {
            if ($val == $this->tagValue($i + 1)) {
                $val = $this->tagCaption($i + 1) ?: $val;
                break;
            }
        }
        return $val;
    }

    // Get field user options as array
    public function options($pleaseSelect = false, $client = false)
    {
        global $Language;
        $arwrk = [];
        if ($pleaseSelect) { // Add "Please Select"
            if ($client) {
                $arwrk[] = ["lf" => "", "df" => $Language->phrase("PleaseSelect")];
            } else {
                $arwrk[] = ["", $Language->phrase("PleaseSelect")];
            }
        }
        for ($i = 0; $i < $this->OptionCount; $i++) {
            $value = $this->tagValue($i + 1);
            $caption = $this->tagCaption($i + 1) ?: $value;
            if ($client) {
                $arwrk[] = ["lf" => $value, "df" => $caption];
            } else {
                $arwrk[] = [$value, $caption];
            }
        }
        return $arwrk;
    }

    // Href path
    public function hrefPath()
    {
        $path = UploadPath(false, ($this->HrefPath != "") ? $this->HrefPath : $this->UploadPath);
        if (preg_match('/^s3:\/\/([^\/]+)/i', $path, $m)) {
            $options = stream_context_get_options(stream_context_get_default());
            $client = @$options["s3"]["client"];
            if ($client) {
                $r = Random();
                $path = $client->getObjectUrl($m[1], $r);
                return explode($r, $path)[0];
            }
        }
        return $path;
    }

    // Physical upload path
    public function physicalUploadPath()
    {
        return ServerMapPath($this->UploadPath);
    }

    // Old Physical upload path
    public function oldPhysicalUploadPath()
    {
        return ServerMapPath($this->OldUploadPath);
    }

    // Get select options HTML
    public function selectOptionListHtml($name = "")
    {
        global $Language;
        $empty = true;
        $curValue = (CurrentPage()->RowType == ROWTYPE_SEARCH) ? (StartsString("y", $name) ? $this->AdvancedSearch->SearchValue2 : $this->AdvancedSearch->SearchValue) : $this->CurrentValue;
        $str = "";
        if (is_array($this->EditValue)) {
            $ar = $this->EditValue;
            if ($this->SelectMultiple) {
                $armulti = (strval($curValue) != "") ? explode(",", strval($curValue)) : [];
                $cnt = count($armulti);
                $rowcnt = count($ar);
                $empty = true;
                for ($i = 0; $i < $rowcnt; $i++) {
                    $sel = false;
                    for ($ari = 0; $ari < $cnt; $ari++) {
                        if (SameString($ar[$i][0], $armulti[$ari]) && $armulti[$ari] != null) {
                            $armulti[$ari] = null; // Marked for removal
                            $sel = true;
                            $empty = false;
                            break;
                        }
                    }
                    if (!$sel) {
                        continue;
                    }
                    foreach ($ar[$i] as $k => $v) {
                        $ar[$i][$k] = RemoveHtml(strval($ar[$i][$k]));
                    }
                    $str .= "<option value=\"" . HtmlEncode($ar[$i][0]) . "\" selected>" . $this->displayValue($ar[$i]) . "</option>";
                }
            } else {
                if ($this->UsePleaseSelect) {
                    $str .= "<option value=\"\">&nbsp;</option>"; // Blank option
                }
                $rowcnt = count($ar);
                $empty = true;
                for ($i = 0; $i < $rowcnt; $i++) {
                    if (SameString($curValue, $ar[$i][0])) {
                        $empty = false;
                    } else {
                        continue;
                    }
                    foreach ($ar[$i] as $k => $v) {
                        $ar[$i][$k] = RemoveHtml(strval($ar[$i][$k]));
                    }
                    $str .= "<option value=\"" . HtmlEncode($ar[$i][0]) . "\" selected>" . $this->displayValue($ar[$i]) . "</option>";
                }
            }
            if ($this->SelectMultiple) {
                for ($ari = 0; $ari < $cnt; $ari++) {
                    if ($armulti[$ari] != null) {
                        $str .= "<option value=\"" . HtmlEncode($armulti[$ari]) . "\" selected></option>";
                    }
                }
            } else {
                if ($empty && strval($curValue) != "") {
                    $str .= "<option value=\"" . HtmlEncode($curValue) . "\" selected></option>";
                }
            }
        }
        if ($empty) {
            $this->OldValue = "";
        }
        return $str;
    }

    /**
     * Get display field value separator
     *
     * @param int $idx Display field index (1|2|3)
     * @return string
     */
    protected function getDisplayValueSeparator($idx)
    {
        $sep = $this->DisplayValueSeparator;
        return (is_array($sep)) ? @$sep[$idx - 1] : ($sep ?: ", ");
    }

    // Get display field value separator as attribute value
    public function displayValueSeparatorAttribute()
    {
        return HtmlEncode(is_array($this->DisplayValueSeparator) ? json_encode($this->DisplayValueSeparator) : $this->DisplayValueSeparator);
    }

    /**
     * Get display value (for lookup field)
     *
     * @param array|Recordset $rs Record to be displayed
     * @return string
     */
    public function displayValue($rs)
    {
        $ar = is_array($rs) ? $rs : $rs->fields;
        $val = strval(@$ar[1]); // Display field 1
        for ($i = 2; $i <= 4; $i++) { // Display field 2 to 4
            $sep = $this->getDisplayValueSeparator($i - 1);
            if ($sep === null) { // No separator, break
                break;
            }
            if (@$ar[$i] != "") {
                $val .= $sep . $ar[$i];
            }
        }
        return $val;
    }

    /**
     * Get display value from EditValue
     */
    public function getDisplayValue($value)
    {
        if (is_array($value) && count($value) == 1) {
            return $this->displayValue($value[0]);
        }
        return $value;
    }

    // Reset attributes for field object
    public function resetAttributes()
    {
        $this->CssStyle = "";
        $this->CssClass = "";
        $this->CellCssStyle = "";
        $this->CellCssClass = "";
        $this->CellAttrs = new Attributes();
        $this->EditAttrs = new Attributes();
        $this->ViewAttrs = new Attributes();
        $this->LinkAttrs = new Attributes();
    }

    // View attributes
    public function viewAttributes()
    {
        $viewattrs = $this->ViewAttrs;
        if ($this->ViewTag == "IMAGE") {
            $viewattrs["alt"] = (trim($this->ImageAlt) != "") ? trim($this->ImageAlt) : ""; // IMG tag requires alt attribute
        }
        $attrs = $this->ViewCustomAttributes; // Custom attributes
        if (is_array($attrs)) { // Custom attributes as array
            $ar = $attrs;
            $attrs = "";
            $aik = array_intersect_key($ar, $viewattrs->toArray());
            $viewattrs->merge($ar); // Combine attributes
            foreach ($aik as $k => $v) { // Duplicate attributes
                if ($k == "style" || StartsString("on", $k)) { // "style" and events
                    $viewattrs->append($k, $v, ";");
                } else { // "class" and others
                    $viewattrs->append($k, $v, " ");
                }
            }
        }
        if ($this->ViewTag == "IMAGE" && (int)$this->ImageWidth > 0 && (!$this->ImageResize || (int)$this->ImageHeight <= 0)) {
            $viewattrs->append("style", "width: " . (int)$this->ImageWidth . "px", ";");
        }
        if ($this->ViewTag == "IMAGE" && (int)$this->ImageHeight > 0 && (!$this->ImageResize || (int)$this->ImageWidth <= 0)) {
            $viewattrs->append("style", "height: " . (int)$this->ImageHeight . "px", ";");
        }
        $viewattrs->append("style", $this->CssStyle, ";");
        $viewattrs->appendClass($this->CssClass);
        $att = $viewattrs->toString();
        if ($attrs != "") { // Custom attributes as string
            $att .= " " . $attrs;
        }
        return $att;
    }

    // Edit attributes
    public function editAttributes()
    {
        $editattrs = $this->EditAttrs;
        $attrs = $this->EditCustomAttributes; // Custom attributes
        if (is_array($attrs)) { // Custom attributes as array
            $ar = $attrs;
            $attrs = "";
            $aik = array_intersect_key($ar, $editattrs->toArray());
            $editattrs->merge($ar); // Combine attributes
            foreach ($aik as $k => $v) { // Duplicate attributes
                if ($k == "style" || StartsString("on", $k)) { // "style" and events
                    $editattrs->append($k, $v, ";");
                } else { // "class" and others
                    $editattrs->append($k, $v, " ");
                }
            }
        }
        $editattrs->append("style", $this->CssStyle, ";");
        $editattrs->appendClass($this->CssClass);
        if ($this->Disabled) {
            $editattrs["disabled"] = true;
        }
        if ($this->IsInvalid) {
            $editattrs->appendClass("is-invalid");
        }
        if ($this->ReadOnly) {
            if (in_array($this->HtmlTag, ["TEXT", "PASSWORD", "TEXTAREA"])) { // Elements support readonly
                $editattrs["readonly"] = true;
            } else { // Elements do not support readonly
                $editattrs["disabled"] = true;
                $editattrs["data-readonly"] = "1";
                $editattrs->appendClass("disabled");
            }
        }
        $att = $editattrs->toString();
        if ($attrs != "") { // Custom attributes as string
            $att .= " " . $attrs;
        }
        return $att;
    }

    // Cell styles (Used in export)
    public function cellStyles()
    {
        $att = "";
        $style = Concat($this->CellCssStyle, $this->CellAttrs["style"], ";");
        $class = $this->CellCssClass;
        AppendClass($class, $this->CellAttrs["class"]);
        if ($style != "") {
            $att .= " style=\"" . $style . "\"";
        }
        if ($class != "") {
            $att .= " class=\"" . $class . "\"";
        }
        return $att;
    }

    // Cell attributes
    public function cellAttributes()
    {
        $cellattrs = $this->CellAttrs;
        $attrs = $this->CellCustomAttributes; // Custom attributes
        if (is_array($attrs)) { // Custom attributes as array
            $ar = $attrs;
            $attrs = "";
            $aik = array_intersect_key($ar, $cellattrs->toArray());
            $cellattrs->merge($ar); // Combine attributes
            foreach ($aik as $k => $v) { // Duplicate attributes
                if ($k == "style" || StartsString("on", $k)) { // "style" and events
                    $cellattrs->append($k, $v, ";");
                } else { // "class" and others
                    $cellattrs->append($k, $v, " ");
                }
            }
        }
        $cellattrs->append("style", $this->CellCssStyle, ";");
        $cellattrs->appendClass($this->CellCssClass);
        $att = $cellattrs->toString();
        if ($attrs != "") { // Custom attributes as string
            $att .= " " . $attrs;
        }
        return $att;
    }

    // Link attributes
    public function linkAttributes()
    {
        $linkattrs = $this->LinkAttrs;
        $attrs = $this->LinkCustomAttributes; // Custom attributes
        if (is_array($attrs)) { // Custom attributes as array
            $ar = $attrs;
            $attrs = "";
            $aik = array_intersect_key($ar, $linkattrs->toArray());
            $linkattrs->merge($ar); // Combine attributes
            foreach ($aik as $k => $v) { // Duplicate attributes
                if ($k == "style" || StartsString("on", $k)) { // "style" and events
                    $linkattrs->append($k, $v, ";");
                } else { // "class" and others
                    $linkattrs->append($k, $v, " ");
                }
            }
        }
        $href = trim($this->HrefValue);
        if ($href != "") {
            $linkattrs["href"] = $href;
        }
        $att = $linkattrs->toString();
        if ($attrs != "") { // Custom attributes as string
            $att .= " " . $attrs;
        }
        return $att;
    }

    // Header cell CSS class
    public function headerCellClass()
    {
        $class = "ew-table-header-cell";
        return AppendClass($class, $this->HeaderCellCssClass);
    }

    // Footer cell CSS class
    public function footerCellClass()
    {
        $class = "ew-table-footer-cell";
        return AppendClass($class, $this->FooterCellCssClass);
    }

    // Add CSS class to all cells
    public function addClass($class)
    {
        AppendClass($this->CellCssClass, $class);
        AppendClass($this->HeaderCellCssClass, $class);
        AppendClass($this->FooterCellCssClass, $class);
    }

    // Remove CSS class from all cells
    public function removeClass($class)
    {
        RemoveClass($this->CellCssClass, $class);
        RemoveClass($this->HeaderCellCssClass, $class);
        RemoveClass($this->FooterCellCssClass, $class);
    }

    // Get sorting order
    public function getSort()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_SORT") . "_" . $this->FieldVar);
    }

    // Set sorting order
    public function setSort($v)
    {
        if (Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_SORT") . "_" . $this->FieldVar) != $v) {
            $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_SORT") . "_" . $this->FieldVar] = $v;
        }
    }

    // Get next sorting order
    public function getNextSort()
    {
        switch ($this->getSort()) {
            case "ASC":
                return "DESC";
            case "DESC":
                return SameText(Config("SORT_OPTION"), "Tristate") ? "NO" : "ASC";
            case "NO":
                return "ASC";
            default:
                return "ASC";
        }
    }

    // Get view value
    public function getViewValue()
    {
        if (is_object($this->ViewValue)) {
            return $this->ViewValue->toHtml();
        }
        return $this->ViewValue;
    }

    // Export caption
    public function exportCaption()
    {
        if (!$this->Exportable) {
            return;
        }
        return (Config("EXPORT_FIELD_CAPTION")) ? $this->caption() : $this->Name;
    }

    // Export value
    public function exportValue()
    {
        return ($this->ExportOriginalValue) ? $this->CurrentValue : $this->ViewValue;
    }

    // Get temp image
    public function getTempImage()
    {
        if ($this->DataType == DATATYPE_BLOB) {
            $wrkdata = $this->Upload->DbValue;
            if (is_resource($wrkdata) && get_resource_type($wrkdata) == "stream") { // Byte array
                $wrkdata = stream_get_contents($wrkdata);
            }
            if (!empty($wrkdata)) {
                if ($this->ImageResize) {
                    $wrkwidth = $this->ImageWidth;
                    $wrkheight = $this->ImageHeight;
                    ResizeBinary($wrkdata, $wrkwidth, $wrkheight);
                }
                return TempImage($wrkdata);
            }
        } else {
            $wrkfile = $this->Upload->DbValue;
            if (empty($wrkfile)) {
                $wrkfile = $this->CurrentValue;
            }
            if (!empty($wrkfile)) {
                if (!$this->UploadMultiple) {
                    $imagefn = $this->physicalUploadPath() . $wrkfile;
                    if (file_exists($imagefn)) {
                        if ($this->ImageResize) {
                            $wrkwidth = $this->ImageWidth;
                            $wrkheight = $this->ImageHeight;
                            $wrkdata = ResizeFileToBinary($imagefn, $wrkwidth, $wrkheight);
                            return TempImage($wrkdata);
                        } else {
                            if (IsRemote($imagefn)) {
                                return TempImage(file_get_contents($imagefn));
                            } else {
                                return $this->UploadPath . $wrkfile;
                            }
                        }
                    }
                } else {
                    $tmpfiles = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $wrkfile);
                    $tmpimage = "";
                    foreach ($tmpfiles as $tmpfile) {
                        if ($tmpfile != "") {
                            $imagefn = $this->physicalUploadPath() . $tmpfile;
                            if (!file_exists($imagefn)) {
                                continue;
                            }
                            if ($this->ImageResize) {
                                $wrkwidth = $this->ImageWidth;
                                $wrkheight = $this->ImageHeight;
                                $wrkdata = ResizeFileToBinary($imagefn, $wrkwidth, $wrkheight);
                                if ($tmpimage != "") {
                                    $tmpimage .= ",";
                                }
                                $tmpimage .= TempImage($wrkdata);
                            } else {
                                if ($tmpimage != "") {
                                    $tmpimage .= ",";
                                }
                                if (IsRemote($imagefn)) {
                                    $tmpimage .= TempImage(file_get_contents($imagefn));
                                } else {
                                    $tmpimage .= $this->UploadPath . $tmpfile;
                                }
                            }
                        }
                    }
                    return $tmpimage;
                }
            }
        }
        return "";
    }

    // Form value
    public function setFormValue($v, $current = true)
    {
        if (!$this->Raw && $this->DataType != DATATYPE_XML) {
            $v = RemoveXss($v);
        }
        $this->setRawFormValue($v, $current);
    }

    // Form value (Raw)
    public function setRawFormValue($v, $current = true)
    {
        if (is_array($v)) {
            $v = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $v);
        }
        if ($this->DataType == DATATYPE_NUMBER && !IsNumeric($v) && !EmptyValue($v)) { // Check data type
            $this->FormValue = null;
        } else {
            $this->FormValue = $v;
        }
        if ($current) {
            $this->CurrentValue = $this->FormValue;
        }
    }

    // Old value
    public function setOldValue($v)
    {
        if (is_array($v)) {
            $v = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $v);
        }
        if ($this->DataType == DATATYPE_NUMBER && !IsNumeric($v) && !EmptyValue($v)) { // Check data type
            $this->OldValue = null;
        } else {
            $this->OldValue = $v;
        }
    }

    // QueryString value
    public function setQueryStringValue($v, $current = true)
    {
        if (!$this->Raw) {
            $v = RemoveXss($v);
        }
        $this->setRawQueryStringValue($v, $current);
    }

    // QueryString value (Raw)
    public function setRawQueryStringValue($v, $current = true)
    {
        if (is_array($v)) {
            $v = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $v);
        }
        if ($this->DataType == DATATYPE_NUMBER && !IsNumeric($v) && !EmptyValue($v)) { // Check data type
            $this->QueryStringValue = null;
        } else {
            $this->QueryStringValue = $v;
        }
        if ($current) {
            $this->CurrentValue = $this->QueryStringValue;
        }
    }

    // Database value
    public function setDbValue($v)
    {
        $this->DbValue = $v;
        if ($this->isEncrypt() && $v != null) {
            try {
                $v = PhpDecrypt($v, Config("ENCRYPTION_KEY"));
            } catch (\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $e) {
            }
        }
        $this->CurrentValue = $v;
    }

    // Set database value with error default
    public function setDbValueDef(&$row, $value, $default, $skip = false)
    {
        if ($skip || !$this->Visible || $this->Disabled) {
            if (array_key_exists($this->Name, $row)) {
                unset($row[$this->Name]);
            }
            return;
        }
        switch ($this->Type) {
            case 2:
            case 3:
            case 16:
            case 17:
            case 18: // Integer
                $value = trim($value);
                $value = ConvertToIntegerString($value);
                $dbValue = is_numeric($value) ? (int)$value : $default;
                break;
            case 19:
            case 20:
            case 21: // Big integer
                $value = trim($value);
                $value = ConvertToIntegerString($value);
                $dbValue = is_numeric($value) ? $value : $default;
                break;
            case 5:
            case 6:
            case 14:
            case 131: // Double
            case 139:
            case 4: // Single
                $value = trim($value);
                $value = ConvertToFloatString($value);
                $dbValue = is_numeric($value) ? $value : $default;
                break;
            case 7:
            case 133:
            case 134:
            case 135: // Date
            case 141: // XML
            case 145: // Time
            case 146: // DateTiemOffset
                $value = trim($value);
                $dbValue = ($value == "") ? $default : $value;
                break;
            case 201:
            case 203:
            case 129:
            case 130:
            case 200:
            case 202: // String
                $value = trim($value);
                $dbValue = ($value == "") ? $default : ($this->isEncrypt() ? PhpEncrypt($value, Config("ENCRYPTION_KEY")) : $value);
                break;
            case 128:
            case 204:
            case 205: // Binary
                $dbValue = $value ?? $default;
                break;
            case 72: // GUID
                $value = trim($value);
                $dbValue = ($value != "" && CheckGuid($value)) ? $value : $default;
                break;
            case 11: // Boolean
                $dbValue = (is_bool($value) || is_numeric($value)) ? $value : $default;
                break;
            default:
                $dbValue = $value;
        }
        //$this->setDbValue($DbValue); // Do not override CurrentValue
        $this->OldValue = $this->DbValue; // Save old DbValue in OldValue
        $this->DbValue = $dbValue;
        $row[$this->Name] = $this->DbValue;
    }

    // Get session value
    public function getSessionValue()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . $this->FieldVar . "_SessionValue");
    }

    // Set session value
    public function setSessionValue($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . $this->FieldVar . "_SessionValue"] = $v;
    }

    // HTML encode
    public function htmlDecode($v)
    {
        return $this->Raw ? $v : HtmlDecode($v);
    }

    /**
     * Output client side list as JSON
     *
     * @return string
     */
    public function toClientList($currentPage)
    {
        $ar = [];
        if ($this->Lookup) {
            $ar = $this->Lookup->toClientList($currentPage);
            $options = ($this->OptionCount > 0)
                ? $this->options(false, true) // User values
                : $this->lookupOptions(); // Lookup table
            $ar = array_merge($ar, [ "lookupOptions" => $options, "multiple" => $this->isMultiSelect() ]);
        }
        return ArrayToJson($ar);
    }
}
