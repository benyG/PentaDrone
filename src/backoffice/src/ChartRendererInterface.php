<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Chart renderer interface
 */
interface ChartRendererInterface
{

    public function getContainer($width, $height);

    public function getScript($width, $height);
}
