<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Captcha base class
 */
class CaptchaBase implements CaptchaInterface
{
    public $FailureMessage = "";
    public $ResponseField = "";
    public $Response = "";

    // Get element name
    public function getElementName()
    {
        return $this->ResponseField;
    }

    // Get element ID
    public function getElementId()
    {
        $id = $this->ResponseField;
        $pageId = CurrentPageID();
        if ($id != "" && $pageId != "") {
            $id .= "-" . $pageId;
        }
        return $id;
    }

    // Get Session Name
    public function getSessionName()
    {
        global $RouteValues;
        $name = SESSION_CAPTCHA_CODE;
        $pageId = $RouteValues["page"] ?? CurrentPageID();
        if ($pageId != "") {
            $name .= "_" . $pageId;
        }
        return $name;
    }

    // HTML tag
    public function getHtml()
    {
        return "";
    }

    // HTML tag for confirm page
    public function getConfirmHtml()
    {
        return "";
    }

    // Validate
    public function validate()
    {
        return true;
    }

    // Client side validation script
    public function getScript($formName)
    {
        return "";
    }

    // Get failure message
    public function getFailureMessage()
    {
        return $this->FailureMessage;
    }

    // Set failure message
    public function setFailureMessage($msg)
    {
        $this->FailureMessage = $msg;
    }

    // Set default failure message
    public function setDefaultFailureMessage()
    {
        global $Language;
        if (EmptyValue($this->Response)) {
            $this->FailureMessage = $Language->phrase("EnterValidateCode");
        } else {
            $this->FailureMessage = $Language->phrase("IncorrectValidationCode");
        }
    }
}
