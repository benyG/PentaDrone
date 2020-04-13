<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                   ATTENTION!
 * If you see this message in your browser (Internet Explorer, Mozilla Firefox, Google Chrome, etc.)
 * this means that PHP is not properly installed on your web server. Please refer to the PHP manual
 * for more details: http://php.net/manual/install.php
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */

include_once dirname(__FILE__) . '/components/startup.php';
include_once dirname(__FILE__) . '/components/page/login_page.php';
include_once dirname(__FILE__) . '/authorization.php';
include_once dirname(__FILE__) . '/database_engine/mysql_engine.php';
include_once dirname(__FILE__) . '/components/security/user_identity_storage/user_identity_session_storage.php';

function GetConnectionOptions() {
    $result = GetGlobalConnectionOptions();
    $result['client_encoding'] = 'utf8';
    return $result;
}

function OnAfterLogin($userName, $connection, &$canLogin, &$errorMessage) {

}

function OnBeforeLogout($userName, $connection) {

}

SetUpUserAuthorization();

$page = new LoginPage(
    'operationpc.php',
    dirname(__FILE__),
    GetApplication()->GetUserAuthentication(),
    MySqlIConnectionFactory::getInstance(),
    Captions::getInstance('UTF-8')
);


$page->OnAfterLogin->AddListener('OnAfterLogin');
$page->OnBeforeLogout->AddListener('OnBeforeLogout');
$page->OnGetCustomTemplate->AddListener('Global_GetCustomTemplateHandler');
$page->OnCustomHTMLHeader->AddListener('Global_CustomHTMLHeaderHandler');
$page->SetHeader(GetPagesHeader());
$page->SetFooter(GetPagesFooter());
$page->BeginRender();
$page->EndRender();
