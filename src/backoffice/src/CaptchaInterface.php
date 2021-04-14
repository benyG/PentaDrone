<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Captcha interface
 */
interface CaptchaInterface
{

    public function getHtml();

    public function getConfirmHtml();

    public function validate();

    public function getScript($formName);
}
