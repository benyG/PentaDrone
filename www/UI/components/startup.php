<?php

include_once dirname(__FILE__) . '/utils/check_utils.php';
CheckPHPVersion();
CheckTemplatesCacheFolderIsExistsAndWritable();

include_once dirname(__FILE__) . '/../phpgen_settings.php';
include_once dirname(__FILE__) . '/security/user_identity.php';

session_start();
