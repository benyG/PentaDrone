<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * List action class
 */
class ListAction
{
    public $Action = "";
    public $Caption = "";
    public $Allow = true;
    public $Method = ACTION_POSTBACK; // Post back (p) / Ajax (a)
    public $Select = ACTION_MULTIPLE; // Multiple (m) / Single (s)
    public $ConfirmMsg = "";
    public $Icon = "fas fa-star ew-icon"; // Icon
    public $Success = ""; // JavaScript callback function name

    // Constructor
    public function __construct($action, $caption, $allow = true, $method = ACTION_POSTBACK, $select = ACTION_MULTIPLE, $confirmMsg = "", $icon = "fas fa-star ew-icon", $success = "")
    {
        $this->Action = $action;
        $this->Caption = $caption;
        $this->Allow = $allow;
        $this->Method = $method;
        $this->Select = $select;
        $this->ConfirmMsg = $confirmMsg;
        $this->Icon = $icon;
        $this->Success = $success;
    }

    // To JSON
    public function toJson($htmlEncode = false)
    {
        $ar = [
            "msg" => $this->ConfirmMsg,
            "action" => $this->Action,
            "method" => $this->Method,
            "select" => $this->Select,
            "success" => $this->Success
        ];
        $json = JsonEncode($ar);
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }
}
